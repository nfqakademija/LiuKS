<?php

namespace Liuks\GameBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TournamentControllerTest extends WebTestCase
{
    public function testShowTournament()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/tournaments/1/show');
        $this->assertTrue($client->getResponse()->isSuccessful());
    }
}
