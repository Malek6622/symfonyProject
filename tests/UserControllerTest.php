<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function getToken()
    {
        return 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2MTk0MjcyMzcsImV4cCI6MTYxOTc4NzIzNywicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoidXNlcjBAZ21haWwuY29tIn0.16_tfZuxLkCCuPdA-M917KLpZIL3UGzkK_zFB7lpI1Gv0gBJZjgmlbJFSei_H17PyOGeXQraPmWOlKRQ-kFCvAdiyMtkiz79tB-OXwOs6Kb_qnu5H4j5pxVTN_SxrwS1Z9uox_5ZUxCI9hrDdcm5MqmP5reiurGKswAycdyOpzHOfHL4qcpqtcT3HO3GtdxDPEF0HavrtsUSIyszEPVmXgu4cJODZiRR1nLK_XAQzFNoQetOXQ4Rz5XPIyRrKlJ9d_6fTca0nFHs57fUsGuZ8SHd9UbV2NqgEi0UHwPM-V4kDFg9BRlfBEvviMhc2Kl2bHPKaHFIfviOwI-_otlcOiynsyZ9EtmTmG9TqhU8AdmawKtN0YKX9bMxyGVS6bU27vMgb_0cDtg3aoJW4yqkxixHTaDlrTVnbiY3MscIXF2Jc1L0EnwDo_k0RTGCBHMldtk9GjD4wA7Po8ps_AzEAhDSXA_SVIrhQflr4Ma2tbzLMNomHcWrcoaIUp844H_BMREA9dtackdopqoajUzvIJgbKgAgfYGD_FLBqrPXnHLpXreFybXB4HREPk4U3YXhChRZ5BAVgcIzJzXtMH8aiKCN0uXxb39BclUCUZwHntP8PqSVNmN2jIdMw7qgDrf-HTqWFYDJOcbNH1o1RCk2OQfc9i0dzYdf_dFjhZcjAN4';
    }

    public function testCreateUser()
    {
        $this->client = static::createClient();
        $this->client->request(
            'POST',
            'api/user/create',
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json'),
            '{
            "email" : "malek123@gmail.com",
            "firstName" : "malekGafsi",
            "password" : "123",
            "phoneNumber" : 684646,
            "cin" : "45855225",
            "birthDate" : "1998-07-16",
            "departmentId" : 1,
            "products" : [1, 2]
            }'
        );
        $this->assertResponseIsSuccessful();
        $response = $this->client->getResponse();
        $this->assertResponseStatusCodeSame(201);
        $user = json_decode($response->getContent());
    }

    public function testUpdateUserWithoutToken()
    {
        $this->client = static::createClient();
        $this->client->request(
            'PUT',
            'api/user/update/3',
            array(),
            array(),
            [
                'HTTP_AUTHORIZATION' => "",
                'CONTENT_TYPE' => 'application/json',
                'HTTP_ACCEPT' => 'application/ld+json'
            ],
            '{
            "email" : "malek123@gmail.com",
            "firstName" : "malekGafsi",
            "password" : "123",
            "phoneNumber" : 684646,
            "cin" : "45855225",
            "birthDate" : "1998-07-16",
            "departmentId" : 1,
            "products" : [1, 2]
            }'
        );
        $this->assertResponseStatusCodeSame(401);
    }

    public function testUpdateUserWithToken()
    {
        $token = $this->getToken();
        $this->client = static::createClient();
        $this->client->request(
            'PUT',
            'api/user/update/3',
            array(),
            array(),
            [
                'HTTP_AUTHORIZATION' => "{$token}",
                'CONTENT_TYPE' => 'application/json',
                'HTTP_ACCEPT' => 'application/ld+json'
            ],
            '{
                    "email" : "malek123@gmail.com",
                    "firstName" : "malekGafsiUpdated",
                    "password" : "123",
                    "phoneNumber" : 684646,
                    "cin" : "45855225",
                    "birthDate" : "1998-07-16",
                    "departmentId" : 1,
                    "products" : [1, 2]
                    }'
        );
        $this->assertResponseIsSuccessful();
        $response = $this->client->getResponse();
        $this->assertResponseStatusCodeSame(201);
        $user = json_decode($response->getContent());
    }

    public function testDeleteUserWithToken()
    {
        $token = $this->getToken();
        $this->client = static::createClient();
        $this->client->request(
            'DELETE',
            'api/user/delete/1',
            array(),
            array(),
            [
                'HTTP_AUTHORIZATION' => "{$token}",
                'CONTENT_TYPE' => 'application/json',
                'HTTP_ACCEPT' => 'application/ld+json'
            ]
        );
        $this->assertResponseIsSuccessful();
        $response = $this->client->getResponse();
        $this->assertResponseStatusCodeSame(200);
    }

    public function testGetOneUserWithToken()
    {
        $token = $this->getToken();
        $this->client = static::createClient();
        $this->client->request(
            'GET',
            'api/user/get/1',
            array(),
            array(),
            [
                'HTTP_AUTHORIZATION' => "{$token}",
                'CONTENT_TYPE' => 'application/json',
                'HTTP_ACCEPT' => 'application/ld+json'
            ]
        );
        $this->assertResponseIsSuccessful();
        $response = $this->client->getResponse();
        $this->assertResponseStatusCodeSame(200);
    }

    public function testGetUsersWithToken()
    {
        $token = $this->getToken();
        $this->client = static::createClient();
        $this->client->request(
            'GET',
            'api/user/get',
            array(),
            array(),
            [
                'HTTP_AUTHORIZATION' => "{$token}",
                'CONTENT_TYPE' => 'application/json',
                'HTTP_ACCEPT' => 'application/ld+json'
            ]
        );
        $this->assertResponseIsSuccessful();
        $response = $this->client->getResponse();
        $this->assertResponseStatusCodeSame(200);
    }
}
