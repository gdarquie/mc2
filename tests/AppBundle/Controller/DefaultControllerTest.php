<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Search a movie', $crawler->filter('.container h2')->text());
    }

    public function testFilm(){
        $client = static::createClient();

        $crawler = $client->request('GET', '/film/id/3839');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('The Jazz Singer', $crawler->filter('.container h1')->text());
    }

    public function testNumber(){
        $client = static::createClient();

        $crawler = $client->request('GET', '/number/1407');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Opening credits', $crawler->filter('.container h1')->text());
    }

}
