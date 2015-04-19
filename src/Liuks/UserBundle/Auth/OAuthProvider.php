<?php

namespace Liuks\UserBundle\Auth;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthAwareUserProviderInterface;
use Liuks\UserBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class OAuthProvider implements UserProviderInterface, OAuthAwareUserProviderInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @param ContainerInterface $container
     */
    public function setContainer($container)
    {
        $this->container = $container;
    }

    public function loadUserByUsername($username)
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $user = $em->getRepository('LiuksUserBundle:User')->findOneBy(['facebookId' => $username]);
        return $user;
    }

    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $fb_id = $response->getUsername();
        $user = $this->loadUserByUsername($fb_id);

        if (!$user)
        {
            $em = $this->container->get('doctrine.orm.default_entity_manager');
            $user = new User();
            $user->setFacebookId($fb_id);
            $user->setEmail($response->getEmail());
            $realname = $response->getRealName();
            $user->setName(explode(' ', $realname, 2)[0]);
            $user->setSurname(explode(' ', $realname, 2)[1]);
            $user->setPicture($response->getProfilePicture());
            $user->setRoles('ROLE_USER');
            $user->setGamesPlayed(0);
            $user->setGamesWon(0);
            $em->persist($user);
            $em->flush($user);

            $user->setRoles('ROLE_USER, ROLE_NEW_USER');
        }

        return $user;
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$this->supportsClass(get_class($user))) {
            throw new UnsupportedUserException(sprintf('Unsupported user class "%s"', get_class($user)));
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class)
    {
        return $class === 'Liuks\\UserBundle\\Entity\\User';
    }
}