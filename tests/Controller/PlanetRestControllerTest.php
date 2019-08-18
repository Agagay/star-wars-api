<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PlanetRestControllerTest extends WebTestCase
{
    private $username = 'root';
    private $password = 'root';

    protected function login()
    {
        $client = static::createClient();

        $client->request('POST', '/api/auth/login', [], [], [],
            '{"username":"' . $this->username . '","password":"' . $this->password . '"}');

        $token = json_decode($client->getResponse()->getContent());

        return (string)$token->token;
    }

    public function testGetOne()
    {
        $client = static::createClient();

        $token = $this->login();

        $client->request('GET', '/api/planet/911', [], [], [
            'HTTP_Authorization' => 'Bearer ' . $token
        ]);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testGetAll()
    {
        $client = static::createClient();

        $token = $this->login();

        $client->request('GET', '/api/planet', [], [], [
            'HTTP_Authorization' => 'Bearer ' . $token
        ]);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testAdd()
    {
        $client = static::createClient();

        $token = $this->login();

        $data = [
            'name' => 'name',
            'population' => 3000,
            'climate' => 'climate',
            'rotation_period' => 24,
            'orbital_period' => 365,
            'diameter' => 10000,
            'gravity' => '1 standart',
            'terrain' => 'jungle',
            'surface_water' => 50
        ];

        $client->request('POST', '/api/planet', $data, [], [
            'HTTP_Authorization' => 'Bearer ' . $token
        ]);

        $this->assertEquals(201, $client->getResponse()->getStatusCode());
    }

    public function testEdit()
    {
        $client = static::createClient();

        $token = $this->login();

        $data = [
            'name' => 'asdasd',
            'population' => 3000,
            'climate' => 'climate',
            'rotation_period' => 24,
            'orbital_period' => 365,
            'diameter' => 10000,
            'gravity' => '1 standart',
            'terrain' => 'jungle',
            'surface_water' => 50
        ];

        $client->request('PUT', '/api/planet/911', $data, [], [
            'HTTP_Authorization' => 'Bearer ' . $token
        ]);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testDelete()
    {
        $client = static::createClient();

        $token = $this->login();

        $client->request('DELETE', '/api/planet/911', [], [], [
            'HTTP_Authorization' => 'Bearer ' . $token
        ]);

        $this->assertEquals(204, $client->getResponse()->getStatusCode());
    }
}
