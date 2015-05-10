<?php

namespace Liuks\UserBundle\Controller;

use Liuks\UserBundle\Entity\Team;
use Liuks\UserBundle\Form\TeamType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TeamController extends Controller
{
    /**
     * Lists all Team entities.
     *
     */
    public function indexAction()
    {
        $em = $this->get('doctrine.orm.default_entity_manager');

        $teams = $em->getRepository('LiuksUserBundle:Team')->
        findBy([], ['gamesWon' => 'DESC', 'totalGoals' => 'DESC']);

        return $this->render(
            'LiuksUserBundle:Team:index.html.twig',
            [
                'teams' => $teams,
            ]
        );
    }

    /**
     * Creates a new Team entity.
     *
     * @Security("has_role('ROLE_USER')")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $team = new Team();
        $form = $this->createCreateForm($team);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.default_entity_manager');
            $player = $em->getRepository('LiuksUserBundle:User')->
            findOneBy(['email' => $team->getPlayer()->getEmail()]);

            $team->setPlayer($player);
            $team->setCaptain($this->getUser());
            $team->setGamesPlayed(0);
            $team->setGamesWon(0);
            $team->setTotalGoals(0);

            $em->persist($team);
            $em->flush($team);

            return $this->redirect($this->generateUrl('teams_show', ['id' => $team->getId()]));
        }

        return $this->render(
            'LiuksUserBundle:Team:new.html.twig',
            [
                'team' => $team,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * Creates a form to create a Team entity.
     *
     * @param Team $team The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Team $team)
    {
        $form = $this->createForm(
            new TeamType(),
            $team,
            [
                'action' => $this->generateUrl('teams_create'),
                'method' => 'POST',
            ]
        );

        $form->add('submit', 'submit', ['label' => 'Sukurti', 'attr' => ['class' => 'btn btn-success']]);

        return $form;
    }

    /**
     * Displays a form to create a new Team entity.
     *
     * @Security("has_role('ROLE_USER')")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction()
    {
        $team = new Team();
        $form = $this->createCreateForm($team);

        return $this->render(
            'LiuksUserBundle:Team:new.html.twig',
            [
                'team' => $team,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * Finds and displays a Team entity.
     *
     * @Security("has_role('ROLE_USER')").
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction($id)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');

        $team = $em->getRepository('LiuksUserBundle:Team')->find($id);

        if (!$team) {
            throw $this->createNotFoundException('Unable to find Team entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render(
            'LiuksUserBundle:Team:show.html.twig',
            [
                'team' => $team,
                'delete_form' => $deleteForm->createView(),
            ]
        );
    }

    /**
     * Creates a form to delete a Team entity by id.
     *
     * @param mixed $id The team id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('teams_delete', ['id' => $id]))
            ->setMethod('DELETE')
            ->add('submit', 'submit', ['label' => 'Ištrinti', 'attr' => ['class' => 'btn btn-danger']])
            ->getForm();
    }

    /**
     * Displays a form to edit an existing Team entity.
     *
     * @Security("has_role('ROLE_USER')")
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction($id)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');

        $team = $em->getRepository('LiuksUserBundle:Team')->find($id);

        if (!$team) {
            throw $this->createNotFoundException('Unable to find Team.');
        }

        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')
            && $this->getUser() != $team->getCaptain()
        ) {
            throw $this->createAccessDeniedException('Unable to access this page!');
        }

        $editForm = $this->createEditForm($team);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render(
            'LiuksUserBundle:Team:edit.html.twig',
            [
                'team' => $team,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ]
        );
    }

    /**
     * Creates a form to edit a Team entity.
     *
     * @param Team $team The team
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Team $team)
    {
        $form = $this->createForm(
            new TeamType(),
            $team,
            [
                'action' => $this->generateUrl('teams_update', ['id' => $team->getId()]),
                'method' => 'PUT',
            ]
        );

        $form->add('submit', 'submit', ['label' => 'Atnaujinti', 'attr' => ['class' => 'btn btn-success']]);

        return $form;
    }

    /**
     * Edits an existing Team entity.
     *
     * @Security("has_role('ROLE_USER')")
     *
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');

        $team = $em->getRepository('LiuksUserBundle:Team')->find($id);

        if (!$team) {
            throw $this->createNotFoundException('Unable to find Team entity.');
        }

        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')
            && $this->getUser() != $team->getCaptain()
        ) {
            throw $this->createAccessDeniedException('Unable to access this page!');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($team);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $player = $em->getRepository('LiuksUserBundle:User')->
            findOneBy(['email' => $team->getPlayer()->getEmail()]);

            $team->setPlayer($player);
            $em->flush($team);

            return $this->redirect($this->generateUrl('teams_edit', ['id' => $id]));
        }

        return $this->render(
            'LiuksUserBundle:Team:edit.html.twig',
            [
                'team' => $team,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ]
        );
    }

    /**
     * Deletes a Team entity.
     *
     * @Security("has_role('ROLE_USER')")
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
            $team = $em->getRepository('LiuksUserBundle:Team')->find($id);

            if (!$team) {
                throw $this->createNotFoundException('Unable to find Team team.');
            }

            if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')
                && $this->getUser() != $team->getCaptain()
            ) {
                throw $this->createAccessDeniedException('Unable to access this page!');
            }

            $em->remove($team);
            $em->flush($team);
        }

        return $this->redirect($this->generateUrl('teams'));
    }
}
