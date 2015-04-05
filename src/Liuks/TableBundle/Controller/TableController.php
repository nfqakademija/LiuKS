<?php

namespace Liuks\TableBundle\Controller;

use Liuks\TableBundle\Events\TableCreationEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Liuks\TableBundle\Entity\Table;
use Liuks\TableBundle\Form\TableType;

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
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('LiuksTableBundle:Table')->findAll();

        return $this->render('LiuksTableBundle:Table:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $entity = new Table();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity->setDisabled(0);
            $entity->setFree(1);
            $entity->setLastShake(0);
            $entity->setLastEventId(0);
            $entity->setGroup($em->getRepository('LiuksUserBundle:Groups')->find(1)); //TODO: get from user which creates table
            $em->persist($entity);
            $em->flush();

            $tableEvent = new TableCreationEvent();
            $tableEvent->setTable($entity);
            $dispatcher = $this->container->get('event_dispatcher');
            $dispatcher->dispatch($tableEvent::TABLECREATED, $tableEvent);

            return $this->redirect($this->generateUrl('table_show', array('id' => $entity->getId())));
        }

        return $this->render('LiuksTableBundle:Table:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Table entity.
     *
     * @param Table $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Table $entity)
    {
        $form = $this->createForm(new TableType(), $entity, array(
            'action' => $this->generateUrl('table_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Table entity.
     *
     */
    public function newAction()
    {
        $entity = new Table();
        $form   = $this->createCreateForm($entity);

        return $this->render('LiuksTableBundle:Table:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Table entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiuksTableBundle:Table')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Table entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('LiuksTableBundle:Table:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Table entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiuksTableBundle:Table')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Table entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('LiuksTableBundle:Table:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Table entity.
    *
    * @param Table $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Table $entity)
    {
        $form = $this->createForm(new TableType(), $entity, array(
            'action' => $this->generateUrl('table_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Table entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiuksTableBundle:Table')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Table entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('table_edit', array('id' => $id)));
        }

        return $this->render('LiuksTableBundle:Table:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Table entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('LiuksTableBundle:Table')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Table entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('tables'));
    }

    /**
     * Creates a form to delete a Table entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('table_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    public function dataAction($id)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');

        $table = $em->getRepository('LiuksTableBundle:Table')->find($id);
        if (!$table)
        {
            throw $this->createNotFoundException('Ooops, it looks like this table is in another dimension...');
        }
        $records = $this->get('api_data.service')->getData($table->getApi(), $table->getLastEventId());

        $action = ''; //for debug
        foreach ($records as $record)
        {
            $action = $record->type;
            $action_time = $record->timeSec;
            switch ($record->type)
            {
                case "TableShake":
                    if ($table->getLastShake() == 0)
                    {
                        $table->setLastShake($action_time);
                    }
                    //TODO: set lastShake to 0 every 1 minute
                    break;
                case "AutoGoal":
                    $this->get('game_utils.service')->calculatePoints($id, $record->data->team, $action_time);
                    break;
                case "CardSwipe":
                    $user = $em->getRepository('LiuksUserBundle:Users')->findOneBy(['cardId' => $record->data->card_id]);
                    if (!$user)
                    {
                        //TODO: create new user (event or service)
                    }
                    else
                    {
                        $this->get('game_utils.service')->addPlayer($id, $record->data->team, $record->data->player, $user);
                    }
                    break;
                default:
                    break;
            }
        }
        $table->setLastEventId(end($records)->id);
        $em->flush($table);

        $game = $this->get('game_utils.service')->getCurrentGame($id);
        return $this->render('LiuksTableBundle:Table:data.html.twig', ['game' => $game, 'shake' => $table->getLastShake(), 'action' => $action]);
    }
}
