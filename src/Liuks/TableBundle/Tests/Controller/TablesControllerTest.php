<?php

namespace Liuks\TableBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TableControllerTest extends WebTestCase
{
    public function testShowTable()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/tables/1/show');
        $this->assertTrue($client->getResponse()->isSuccessful());
    }
}
