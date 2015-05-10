<?php

namespace Liuks\UserBundle\Controller;

use Liuks\UserBundle\Entity\User;
use Liuks\UserBundle\Form\UsersType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Users controller.
 *
 */
class UsersController extends Controller
{
    /**
     * Lists all Users entities.
     *
     */
    public function indexAction()
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');

        $users = $em->getRepository('LiuksUserBundle:User')
            ->findBy([], ['gamesWon' => 'DESC', 'gamesPlayed' => 'DESC']);

        return $this->render(
            'LiuksUserBundle:Users:index.html.twig',
            [
                'users' => $users,
            ]
        );
    }

    /**
     * Finds and displays a sigle user based on id
     *
     * @Security("has_role('ROLE_USER')")
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction($id)
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');

        $user = $em->getRepository('LiuksUserBundle:User')->find($id);

        if (!$user) {
            throw $this->createNotFoundException('This User Does Not Exists.');
        }
        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')
            && $this->getUser() != $user
        ) {
            throw $this->createAccessDeniedException('Unable to access this page!');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render(
            'LiuksUserBundle:Users:show.html.twig',
            [
                'user' => $user,
                'delete_form' => $deleteForm->createView(),
            ]
        );
    }

    /**
     * Creates a form to delete a Users entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('users_delete', ['id' => $id]))
            ->setMethod('DELETE')
            ->add('submit', 'submit', ['label' => 'Delete', 'attr' => ['class' => 'btn btn-danger']])
            ->getForm();
    }

    /**
     * Displays a form to edit an existing Users.
     *
     * @Security("has_role('ROLE_USER')")
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction($id)
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');

        $user = $em->getRepository('LiuksUserBundle:User')->find($id);

        if (!$user) {
            throw $this->createNotFoundException('Unable to find User.');
        }

        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')
            && $this->getUser() != $user
        ) {
            throw $this->createAccessDeniedException('Unable to access this page!');
        }

        $editForm = $this->createEditForm($user);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render(
            'LiuksUserBundle:Users:edit.html.twig',
            [
                'user' => $user,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ]
        );
    }

    /**
     * Creates a form to edit a Users entity.
     *
     * @param User $user The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(User $user)
    {
        $form = $this->createForm(
            new UsersType(),
            $user,
            [
                'action' => $this->generateUrl('users_update', ['id' => $user->getId()]),
                'method' => 'PUT',
            ]
        );

        $form->add('submit', 'submit', ['label' => 'Atnaujinti', 'attr' => ['class' => 'btn btn-success']]);

        return $form;
    }

    /**
     * Edits an existing Users entity.
     *
     * @Security("has_role('ROLE_USER')")
     *
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');

        $user = $em->getRepository('LiuksUserBundle:User')->find($id);

        if (!$user) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')
            && $this->getUser() != $user
        ) {
            throw $this->createAccessDeniedException('Unable to access this page!');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($user);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('users_edit', ['id' => $id]));
        }

        return $this->render(
            'LiuksUserBundle:Users:edit.html.twig',
            [
                'user' => $user,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ]
        );
    }

    /**
     * Deletes a Users entity.
     *
     * @Security("has_role('ROLE_ADMIN')")
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
            $em = $this->container->get('doctrine.orm.default_entity_manager');
            $user = $em->getRepository('LiuksUserBundle:User')->find($id);

            if (!$user) {
                throw $this->createNotFoundException('Unable to find User entity.');
            }

            if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')
                && $this->getUser() != $user
            ) {
                throw $this->createAccessDeniedException('Unable to access this page!');
            }

            $em->remove($user);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('users'));
    }

    /**
     * Creates a view where user can chose his default table.
     *
     * @Security("has_role('ROLE_USER')")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function locatorAction()
    {
        return $this->render('LiuksUserBundle:Users:locate.html.twig');
    }

    /**
     *
     * @Security("has_role('ROLE_USER')")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function closestTableAction()
    {
        $request = $this->container->get('request');
        $lat = $request->get('lat');
        $long = $request->get('long');
        $tables = $this->container->get('table_actions.service')->findClosestTables($lat, $long);

        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('users_set_default_table', ['id' => $tables[0]->getId()]))
            ->setMethod('PUT')
            ->add('submit', 'submit', ['label' => 'Pasirinkti'])
            ->getForm()->createView();

        return $this->render(
            'LiuksUserBundle:Users:closestTable.html.twig',
            [
                'tables' => $tables,
                'setTableForm' => $form
            ]
        );
    }

    /**
     * @Security("has_role('ROLE_USER')")
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function setDefaultTableAction($id)
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $table = $em->getRepository('LiuksTableBundle:Table')->find($id);
        $user = $this->getUser();
        $user->setDefaultTable($table);
        $em->flush($user);

        return $this->redirectToRoute('home_page');
    }
}
