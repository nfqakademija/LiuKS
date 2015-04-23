<?php

namespace Liuks\GameBundle\Controller;

use Liuks\TableBundle\Entity\Table;
use Liuks\GameBundle\Entity\Tournament;
use Liuks\GameBundle\Form\TournamentType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
        if (!$tournament)
        {
            throw $this->createNotFoundException('Unable to find Tournament entity.');
        }
        $data = $this->get('tournament_utils.service')->getTournamentData($tournament);
        $form = $this->createDeleteForm($tournament->getId());
        return $this->render('LiuksGameBundle:Tournament:show.html.twig',
            [
                'data' => $data,
                'tournament' => $tournament,
                'delete_form' => $form->createView()
            ]);
    }

    /**
     * Lists all Tournament entities.
     *
     */
    public function indexAction()
    {
        $em = $this->get('doctrine.orm.default_entity_manager');

        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN'))
        {
            $tournaments = $em->getRepository('LiuksGameBundle:Tournament')->findAll();
        }
        else if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY'))
        {
            $tournaments = $em->createQuery(
                'SELECT t FROM LiuksGameBundle:Tournament t
                JOIN t.table table
                WHERE table.owner = :owner OR table.private = 0')
                ->setParameter('owner', $this->getUser())
                ->getResult();
        }
        else
        {

            $tournaments = $em->createQuery(
                'SELECT t FROM LiuksGameBundle:Tournament t
                JOIN t.table table
                WHERE table.private = 0')
                ->getResult();
        }

        return $this->render('LiuksGameBundle:Tournament:index.html.twig', array(
            'tournaments' => $tournaments,
        ));
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

        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $tournament->setEndTime(0);
            $tournament->setStartTime(0);
            $tournament->setOrganizer($this->getUser());
            $em->persist($tournament);
            $em->flush($tournament);

            return $this->redirect($this->generateUrl('tournament_show', array('id' => $tournament->getId())));
        }

        return $this->render('LiuksGameBundle:Tournament:new.html.twig', array(
            'tournament' => $tournament,
            'form'   => $form->createView(),
        ));
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
        $form = $this->createForm(new TournamentType(), $tournament, array(
            'action' => $this->generateUrl('tournament_create'),
            'method' => 'POST',
            'attr'   => ['class' => 'form-horizontal']
        ))
            ->add('submit', 'submit', array('label' => 'Sukurti'));

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
        $form   = $this->createCreateForm($tournament);

        return $this->render('LiuksGameBundle:Tournament:new.html.twig', array(
            'tournament' => $tournament,
            'form'   => $form->createView()
        ));
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
        $data = $this->get('tournament_utils.service')->getTournamentData($tournament);
        $form = $this->createDeleteForm($id);
        return $this->render('LiuksGameBundle:Tournament:show.html.twig',
            [
                'data' => $data,
                'tournament' => $tournament,
                'delete_form' => $form->createView()
            ]);
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

        if (!$tournament)
        {
            throw $this->createNotFoundException('Unable to find Tournament entity.');
        }

        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')
            || $this->getUser() != $tournament->getOrganizer()
            || $this->getUser() != $tournament->getTable()->getOwner())
        {
            throw $this->createAccessDeniedException('Unable to access this page!');
        }

        $form = $this->createEditForm($tournament);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('LiuksGameBundle:Tournament:edit.html.twig', array(
            'tournament'      => $tournament,
            'form'        => $form->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Tournament entity.
     *
     * @param Tournament $tournament
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Tournament $tournament)
    {
        $form = $this->createForm(new TournamentType(), $tournament, array(
            'action' => $this->generateUrl('tournament_update', array('id' => $tournament->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Atnaujinti'));

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

        if (!$tournament)
        {
            throw $this->createNotFoundException('Unable to find Tournament entity.');
        }


        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')
            || $this->getUser() != $tournament->getOrganizer()
            || $this->getUser() != $tournament->getTable()->getOwner())
        {
            throw $this->createAccessDeniedException('Unable to access this page!');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($tournament);
        $editForm->handleRequest($request);

        if ($editForm->isValid())
        {
            $em->flush($tournament);

            return $this->redirect($this->generateUrl('tournament_edit', array('id' => $id)));
        }

        return $this->render('LiuksGameBundle:Tournament:edit.html.twig', array(
            'tournament'      => $tournament,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
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

            if (!$tournament)
            {
                throw $this->createNotFoundException('Unable to find Tournament entity.');
            }

            if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')
                || $this->getUser() != $tournament->getOrganizer()
                || $this->getUser() != $tournament->getTable()->getOwner())
            {
                throw $this->createAccessDeniedException('Unable to access this page!');
            }

            $em->remove($tournament);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('tournaments'));
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
            ->setAction($this->generateUrl('tournament_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Ištrinti'))
            ->getForm()
            ;
    }
}