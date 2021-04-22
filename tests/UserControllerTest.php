<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function getToken()
    {
        return 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2MTkxMDU2NDksImV4cCI6MTYxOTEwOTI0OSwicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoidXNlcjBAZ21haWwuY29tIn0.AUIX6wfUX81JusvjtriyO61Etb1K9aLRzWkzfXCyg8uZYpepyRc5d5qeGnVb_hEy33kk4bPySKUtD-vCSvUkki0vddqxbVWoiAo5DaCnqghD-WZ8rn-hKystCtwbo6AIkGHpyIrJvHgqERTQ2C1HWQAPUsOBMSdHVlyISDNyIiO2c6fbrnv9wA8jGYtcB85hfFh8jw1uWSVFJ0T6T5BeywWmxsTCmGttrL6JnG6Ce3KEuEdsUFTDr7v32hlG-FiExwhdd8cSHnoEtXppQQWdhFhfPARP5E6VacRUBLA96_LR81K-ONWXgNFu7VT_vNluZbU5zmNzLGcykHDr-nnFwHloxqFfpTVSlfDmz19-VJvRvvySwyph6nM3nIsE1FfNSyo44cu4ZppzwCA4J9QBL_z97pJ5N0L1TEzInQlEwQ0-7e8X3zbAW04mLzCXo78_3ajfuE-EH229ItcsGr4H0uOi4qNHV9VXX9_IdG6xyazwt9Oxbb8CowEKM5zab86KY2s8F60nEvd3casa2ox5J5jxkZSuSuUkZFyU2cMC9NrgRIMgAAg4BmhWoSedx3VVRB1SXz0eFE_5HhjcnEenBFBDXmiMqodppPI_Mc4ywV8DfJtaka81QFqn57AwS8Avb1iS1TpbU0eKkdAQzzKd5r5Xz03x87FTRC83XUd9WxU';
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
