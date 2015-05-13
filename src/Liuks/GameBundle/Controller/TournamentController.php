<?php

namespace Liuks\GameBundle\Controller;

use Liuks\GameBundle\Entity\Tournament;
use Liuks\GameBundle\Form\TournamentType;
use Liuks\TableBundle\Entity\Table;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TournamentController extends Controller
{
    /**
     * Finds and displays an ongoing tournament data for specific table.
     *
     * @param integer $table_id
     * @return \Symfony\Component\HttpFoundation\Response
     *
     */
    public function currentAction($table_id)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');
        $table = $em->getRepository('LiuksTableBundle:Table')->find($table_id);
        $tournament = $em->getRepository('LiuksGameBundle:Tournament')->findOneBy(['table' => $table, 'endTime' => 0]);
        if (!$tournament) {
            throw $this->createNotFoundException('Unable to find Tournament entity.');
        }

        return $this->showAction($tournament->getId());
    }

    /**
     * Finds and displays a Tournament entity.
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     *
     */
    public function showAction($id)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');
        $tournament = $em->getRepository('LiuksGameBundle:Tournament')->find($id);
        $tournament_utils = $this->get('tournament_utils.service');
        $data = $tournament_utils->getTournamentData($tournament);
        if ($tournament->getEndTime() == 0) {
            $game = $this->get('game_utils.service')->getCurrentGame($tournament->getTable());
        } else {
            $game = null;
        }
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $competitors = $em->createQuery(
                'SELECT c FROM LiuksGameBundle:Competitor c
                JOIN c.team team
                WHERE team.player IS NULL AND c.tournament = :tournament'
            )
                ->setParameter('tournament', $tournament)
                ->getResult();
            $form = $this->createDeleteForm($id)->createView();
            $isCompetitor = $tournament_utils->isCompetitor($tournament, $this->getUser());
            $teams = $em->getRepository('LiuksUserBundle:Team')->findBy(['captain' => $this->getUser()]);
        } else {
            $competitors = $form = $isCompetitor = $teams = null;
        }

        return $this->render(
            'LiuksGameBundle:Tournament:show.html.twig',
            [
                'tournament' => $tournament,
                'game' => $game,
                'data' => json_encode($data),
                'competitors' => $competitors,
                'isCompetitor' => $isCompetitor,
                'teams' => $teams,
                'delete_form' => $form
            ]
        );
    }

    /**
     * Creates a form to delete a Tournament entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tournament_delete', ['id' => $id]))
            ->setMethod('DELETE')
            ->add('submit', 'submit', ['label' => 'Ištrinti', 'attr' => ['class' => 'btn btn-danger btn-block']])
            ->getForm();
    }

    /**
     * Lists all Tournament entities.
     *
     */
    public function indexAction()
    {
        $em = $this->get('doctrine.orm.default_entity_manager');

        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            $tournaments = $em->getRepository('LiuksGameBundle:Tournament')->findBy(
                [],
                ['startTime' => 'DESC']
            );
        } else {
            if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
                $tournaments = $em->createQuery(
                    'SELECT t FROM LiuksGameBundle:Tournament t
                JOIN t.table table
                WHERE table.owner = :owner OR table.private = 0
                ORDER BY t.startTime DESC'
                )
                    ->setParameter('owner', $this->getUser())
                    ->getResult();
            } else {
                $tournaments = $em->createQuery(
                    'SELECT t FROM LiuksGameBundle:Tournament t
                JOIN t.table table
                WHERE table.private = 0
                ORDER BY t.startTime DESC'
                )
                    ->getResult();
            }
        }

        return $this->render(
            'LiuksGameBundle:Tournament:index.html.twig',
            [
                'tournaments' => $tournaments,
            ]
        );
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $tournament = new Tournament();
        $form = $this->createCreateForm($tournament);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.default_entity_manager');
            $tournament->setCompetitors(0);
            $tournament->setCurrentRound(0);
            $tournament->setEndTime(0);
            $tournament->setOrganizer($this->getUser());
            $em->persist($tournament);
            $em->flush($tournament);

            return $this->redirect($this->generateUrl('tournament_show', ['id' => $tournament->getId()]));
        }

        return $this->render(
            'LiuksGameBundle:Tournament:new.html.twig',
            [
                'tournament' => $tournament,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * Creates a form to create a Tournament entity.
     *
     * @param Tournament $tournament
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Tournament $tournament)
    {
        $form = $this->createForm(
            new TournamentType(),
            $tournament,
            [
                'action' => $this->generateUrl('tournament_create'),
                'method' => 'POST',
            ]
        )
            ->add(
                'submit',
                'submit',
                ['label' => 'Sukurti', 'attr' => ['class' => 'btn btn-success btn-lg btn-block']]
            );

        return $form;
    }

    /**
     * Displays a form to create a new Tournament entity.
     *
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function newAction()
    {
        $tournament = new Tournament();
        $form = $this->createCreateForm($tournament);

        return $this->render(
            'LiuksGameBundle:Tournament:new.html.twig',
            [
                'tournament' => $tournament,
                'form' => $form->createView()
            ]
        );
    }

    /**
     * Displays a form to edit an existing Tournament entity.
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction($id)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');

        $tournament = $em->getRepository('LiuksGameBundle:Tournament')->find($id);

        if (!$tournament) {
            throw $this->createNotFoundException('Unable to find Tournament entity.');
        }

        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')
            && $this->getUser() != $tournament->getOrganizer()
            && $this->getUser() != $tournament->getTable()->getOwner()
        ) {
            throw $this->createAccessDeniedException('Unable to access this page!');
        }

        $form = $this->createEditForm($tournament);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render(
            'LiuksGameBundle:Tournament:edit.html.twig',
            [
                'tournament' => $tournament,
                'form' => $form->createView(),
                'delete_form' => $deleteForm->createView(),
            ]
        );
    }

    /**
     * Creates a form to edit a Tournament entity.
     *
     * @param Tournament $tournament
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Tournament $tournament)
    {
        $form = $this->createForm(
            new TournamentType(),
            $tournament,
            [
                'action' => $this->generateUrl('tournament_update', ['id' => $tournament->getId()]),
                'method' => 'PUT',
            ]
        );

        $form->add(
            'submit',
            'submit',
            ['label' => 'Atnaujinti', 'attr' => ['class' => 'btn btn-success btn-block btn-lg']]
        );

        return $form;
    }

    /**
     * Edits an existing Tournament entity.
     *
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');

        $tournament = $em->getRepository('LiuksGameBundle:Tournament')->find($id);

        if (!$tournament) {
            throw $this->createNotFoundException('Unable to find Tournament entity.');
        }


        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')
            && $this->getUser() != $tournament->getOrganizer()
            && $this->getUser() != $tournament->getTable()->getOwner()
        ) {
            throw $this->createAccessDeniedException('Unable to access this page!');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($tournament);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush($tournament);

            return $this->redirect($this->generateUrl('tournament_show', ['id' => $id]));
        }

        return $this->render(
            'LiuksGameBundle:Tournament:edit.html.twig',
            [
                'tournament' => $tournament,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ]
        );
    }

    /**
     * Deletes a Tournament entity.
     *
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.default_entity_manager');
            $tournament = $em->getRepository('LiuksGameBundle:Tournament')->find($id);

            if (!$tournament) {
                throw $this->createNotFoundException('Unable to find Tournament entity.');
            }

            if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')
                && $this->getUser() != $tournament->getOrganizer()
                && $this->getUser() != $tournament->getTable()->getOwner()
            ) {
                throw $this->createAccessDeniedException('Unable to access this page!');
            }

            $em->remove($tournament);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('tournaments'));
    }

    /**
     * Adds current user to Tournament based on tournament id.
     *
     * @param integer $id Tournament id
     * @return Response
     */
    public function addPlayerAction($id)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');
        $tournament = $em->getRepository('LiuksGameBundle:Tournament')->find($id);
        $team = $_POST['team'];
        if ($team == 'new') {
            $team = $this->get('users_util.service')->createTeam($this->getUser(), $_POST['team_name']);
            $this->get('tournament_utils.service')->addCompetitor($tournament, $team);
        } elseif ($team == 'existing') {
            $team = $em->getRepository('LiuksUserBundle:Team')->find($_POST['team_id']);
            $this->get('tournament_utils.service')->addCompetitor($tournament, $team);
        } else {
            $this->get('users_util.service')->addTeamMember($team, $this->getUser());
        }

        return new Response('success');
    }

    /**
     * @param $id
     * @return Response
     */
    public function updateFromJsonAction($id)
    {
        $response = null;
        if ($_POST['changed'] == 'results') {
            $response = $this->get('tournament_utils.service')->updateTournamentResultsFromJson($id, $_POST['json']);
        } elseif ($_POST['changed'] == 'teams') {
            $response = $this->get('tournament_utils.service')->updateTournamentTeamsFromJson($id, $_POST['json']);
        }
        if ($response) {
            return new Response('success');
        }

        return new Response('failed');
    }
}