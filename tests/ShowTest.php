<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ShowTest extends WebTestCase
{

    public function testLogIn()
    {
        $client = static::createClient();

        $crawler = $client->request('GET','/login');

        $form = $crawler->selectButton('Войти')->form();

        $form['_username'] = 'Zhecond';
        $form['_password'] = '123';

        $client->submit($form);

        $crawler = $client->followRedirect();

        self::assertGreaterThan(0,$crawler->filter('Log Out')->count());
    }

    public function testAdmin()
    {
        $client = static::createClient();

        $client->request('GET', '/admin');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

}