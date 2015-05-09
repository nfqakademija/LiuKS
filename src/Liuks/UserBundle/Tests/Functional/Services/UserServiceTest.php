<?php

namespace Liuks\GameBundle\Tests\Services;


use Doctrine\ORM\EntityManager;
use Liuks\UserBundle\Entity\User;
use Liuks\UserBundle\Services\UserService;

class UserServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var EntityManager
     */
    private $em;

    public function setUp()
    {
        $this->em = $this->getMock('\Doctrine\ORM\EntityManager', ['persist', 'flush', 'getRepository'], [], '', false);
        $this->em->expects($this->any())->method('persist')->willReturn(null);
        $this->em->expects($this->any())->method('flush')->willReturn(null);
    }

    public function testServiceCreation()
    {
        $userService = new UserService();
        $userService->setEm($this->em);
        $this->assertNotNull($userService);

        return $userService;
    }

    /**
     * @depends testServiceCreation
     * @param UserService $userService
     */
    public function testCreateTeam($userService)
    {
        $user = new User();
        $user->setName('Test')->setSurname('Test')->setFacebookId('123')->setEmail('test@test.com');

        $results = $userService->createTeam($user, 'Test');

        $this->assertInstanceOf('\Liuks\UserBundle\Entity\Team', $results);
        $this->assertInstanceOf('\Liuks\UserBundle\Entity\User', $results->getCaptain());
        $this->assertEquals('Test', $results->getName());
    }
}