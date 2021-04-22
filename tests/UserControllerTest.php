<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function getToken()
    {
        return 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2MTkwOTg3NzUsImV4cCI6MTYxOTEwMjM3NSwicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoidXNlcjBAZ21haWwuY29tIn0.HdPLf3tYoL3atuFjVTqIzGhbAeO1JWl5Xw7uRB22BHdmO_Rhsjaecm4HHWgzLlmUyFo4uXDpOxjxsxRPm2ZlV52uam1ncxvN3X4b-JR4YEMpUNQTPMX5roVBaMGWn90bLYiCk-LsNVeORYudAgHLvkrSe6_vHom4WRPZTC9ZhRTgVKHu4zngwCIs-ZOkdd0y0QjMflCENkDVh1FxxIF49PMXD-KFXBn9glfe4WbItR_Y39dec9y30MSWb-o-zKylFaGNu2UCD5ifExzcGAfCDTAKEN5Jm13FQ4avY13tAbYeISTKH6nxN5R26gypPV5iWFdh2EoeIRIFPr-1RX-rUIJ0LPFK_DSKU6FEj7Mo8Pth9NSpTXx7eyqhM_YAz9B_3_2UjJD7D-Og835n3BB8dezjawOd2VkDfgiA4w1161bBS7R4LDQpyrioAd5KQJExgcf0fqMynYnWkaUPxr-amFStB9R3pLMO4XYE-9zt0Y-9qxu8MpA3PR1mVx__9whyeOoRBxAibYW2k6wOsbPBzyWiWggzOL_KqbgZ1tBoKrt7IMIlBx4uXyV3LGXE1I2CkoBoSud3a2d8YVBipWrWYlIDwZk5-2SMcI1q-QEIAKSbGS0JGqiyll6QOZqHVReWE0qPSz3EC4iwuY0qZPEe42H4b8hp40ab0ZklNc-FrjI';}


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
