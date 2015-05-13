<?php

namespace Liuks\TableBundle\Controller;

use Liuks\TableBundle\Entity\Table;
use Liuks\TableBundle\Events\TableCreationEvent;
use Liuks\TableBundle\Form\TableType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Table controller.
 *
 */
class TableController extends Controller
{

    /**
     * Lists all Table entities.
     *
     */
    public function indexAction()
    {
        $em = $this->get('doctrine.orm.default_entity_manager');

        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            $tables = $em->getRepository('LiuksTableBundle:Table')->findAll();
        } elseif ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $tables = $em->createQuery(
                '
              SELECT t FROM LiuksTableBundle:Table t
              WHERE t.owner = :owner OR t.private = 0'
            )
                ->setParameter('owner', $this->getUser())
                ->getResult();
        } else {
            $tables = $em->getRepository('LiuksTableBundle:Table')->findBy(['disabled' => false, 'private' => false]);
        }

        return $this->render(
            'LiuksTableBundle:Table:index.html.twig',
            [
                'tables' => $tables,
            ]
        );
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $table = new Table();
        $form = $this->createCreateForm($table);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $table->setFree(1);
            $table->setLastShake(0);
            $table->setLastEventId(0);
            $table->setOwner($this->getUser());
            if ($table->getGroup()) {
                $em->persist($table->getGroup());
                $em->flush($table->getGroup());
            }
            $em->persist($table);
            $em->flush($table);

            $tableEvent = new TableCreationEvent();
            $tableEvent->setTable($table);
            $dispatcher = $this->get('event_dispatcher');
            $dispatcher->dispatch($tableEvent::TABLECREATED, $tableEvent);

            return $this->redirect($this->generateUrl('table_show', ['id' => $table->getId()]));
        }

        return $this->render(
            'LiuksTableBundle:Table:new.html.twig',
            [
                'table' => $table,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * Creates a form to create a Table entity.
     *
     * @param Table $table
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Table $table)
    {
        $form = $this->createForm(
            new TableType(),
            $table,
            [
                'action' => $this->generateUrl('table_create'),
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
     * Displays a form to create a new Table entity.
     *
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function newAction()
    {
        $table = new Table();
        $form = $this->createCreateForm($table);

        return $this->render(
            'LiuksTableBundle:Table:new.html.twig',
            [
                'table' => $table,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * Finds and displays a Table entity.
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     *
     */
    public function showAction($id)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');

        $table = $em->getRepository('LiuksTableBundle:Table')->find($id);

        if (!$table) {
            throw $this->createNotFoundException('Ooops, it looks like this table is in another dimension...');
        }

        $games = $em->getRepository('LiuksGameBundle:Game')->findBy(['table' => $table], ['startTime' => 'DESC'], 20);

        $game = null;
        if (array_key_exists(0, $games) && $games[0]->getEndTime() == 0) {
            $game = $games[0];
            array_splice($games, 0, 1);
        }
        $hasTournament = $this->get('table_actions.service')->hasTournamentRegistered($id);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render(
            'LiuksTableBundle:Table:show.html.twig',
            [
                'table' => $table,
                'games' => $games,
                'game' => $game,
                'hasTournament' => $hasTournament,
                'delete_form' => $deleteForm->createView(),
            ]
        );
    }

    /**
     * Creates a form to delete a Table entity by id.
     *
     * @param mixed $id The table id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('table_delete', ['id' => $id]))
            ->setMethod('DELETE')
            ->add('submit', 'submit', ['label' => 'Ištrinti', 'attr' => ['class' => 'btn btn-danger btn-block']])
            ->getForm();
    }

    /**
     * Displays a form to edit an existing Table entity.
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction($id)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');

        $table = $em->getRepository('LiuksTableBundle:Table')->find($id);

        if (!$table) {
            throw $this->createNotFoundException('Unable to find Table entity.');
        }

        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')
            && $this->getUser() != $table->getOwner()
        ) {
            throw $this->createAccessDeniedException('Unable to access this page!');
        }

        $form = $this->createEditForm($table);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render(
            'LiuksTableBundle:Table:edit.html.twig',
            [
                'table' => $table,
                'form' => $form->createView(),
                'delete_form' => $deleteForm->createView(),
            ]
        );
    }

    /**
     * Creates a form to edit a Table entity.
     *
     * @param Table $table The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Table $table)
    {
        $form = $this->createForm(
            new TableType(),
            $table,
            [
                'action' => $this->generateUrl('table_update', ['id' => $table->getId()]),
                'method' => 'PUT',
            ]
        );

        $form->add(
            'submit',
            'submit',
            ['label' => 'Atnaujinti', 'attr' => ['class' => 'btn btn-success btn-lg btn-block']]
        );

        return $form;
    }

    /**
     * Edits an existing Table entity.
     *
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');

        $table = $em->getRepository('LiuksTableBundle:Table')->find($id);

        if (!$table) {
            throw $this->createNotFoundException('Unable to find Table entity.');
        }

        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')
            && $this->getUser() != $table->getOwner()
        ) {
            throw $this->createAccessDeniedException('Unable to access this page!');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($table);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('table_edit', ['id' => $id]));
        }

        return $this->render(
            'LiuksTableBundle:Table:edit.html.twig',
            [
                'table' => $table,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ]
        );
    }

    /**
     * Deletes a Table entity.
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
            $table = $em->getRepository('LiuksTableBundle:Table')->find($id);

            if (!$table) {
                throw $this->createNotFoundException('Unable to find Table entity.');
            }

            if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')
                && $this->getUser() != $table->getOwner()
            ) {
                throw $this->createAccessDeniedException('Unable to access this page!');
            }

            $group = $table->getGroup();
            if ($group) {
                $em->remove($group);
            }

            $em->remove($table);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('tables'));
    }

    /**
     * Finds and displays table entity. Used for default table rendering in homepage.
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function defaultTableShowAction($id)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');
        $table = $em->getRepository('LiuksTableBundle:Table')->find($id);

        if (!$table) {
            throw $this->createNotFoundException('Ooops, it looks like this table is in another dimension...');
        }

        $game = $this->get('game_utils.service')->getCurrentGame($id);
        $hasTournament = $this->get('table_actions.service')->hasTournamentRegistered($id);

        return $this->render(
            'LiuksTableBundle:Table:defaultShow.html.twig',
            [
                'table' => $table,
                'game' => $game,
                'hasTournament' => $hasTournament
            ]
        );
    }

    /**
     * @param int $id Table id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function dataAction($id)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');

        $table = $em->getRepository('LiuksTableBundle:Table')->find($id);
        if (!$table) {
            throw $this->createNotFoundException('Ooops, it looks like this table is in another dimension...');
        }

        if (time() >= $table->getLastDataUpdate() + 10) {
            $table = $this->get('table_actions.service')->updateTableData($table);
            $em->flush($table);
        }

        return new Response('success');
    }
}
