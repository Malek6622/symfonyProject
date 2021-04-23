<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function getToken()
    {
        return 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2MTkxNzE5NzYsImV4cCI6MTYxOTUzMTk3Niwicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoidXNlcjBAZ21haWwuY29tIn0.vxyWxovOoWV-c6XXFMygIwnKyLJYgDNwfn_0qZuF1X9iMAKWsP6hC4i9EitKmI3bZUUxWPcXmEDwiQ2HDK5CCaiLA6bapZCivU8t4mI49ZTHqlVTaskCzjYbn3CtYjf8HIj6QtsaT-uB0Kyp3YOHvCDAatxc_51vj5qOAgUzvPFV7oOb9HKLzV4WLdC39SEQgIf67MnotwMrxBqFSxpk8ibGBovfiA37pB1JZ5jVuW-RYuzPmmpiyUF-B3Rcb-49vjbiEsVmRI9uacA_I-oJq6S7N3N32Zyiqy5bge-TVvhGWWfKDNaKsJauuR6aVe6fv_9mK704hdEidhuXMfP6CiXxRqBndoGM9nPK7Zs_nYGW4fMo30TprWfCKRfdRdadvlI57Iafw4D_U99OxvAIUiZklxiGrHUXYANdgmuVoFaE91PO23mA_GxznKdKxhAQV-oBCowFeoDB1EwpIDRQYik1bhUhYNNVowZsrGajDOS7JF2CE_n3WfJGy_c7eLWIz-qXOCw6jXfpVTOrFfI8Qu_qhd9BbDmAKyF9CdGEviHs5xEZ-xy2OGs2CP65OiCDPRjXdske9dK0AICOY-2suf23iUl3B66gKwygBR8m_k13x4u-uV0WRyq4LSR-w1Y4l16HOLih4ja4iZ16Xn0wauTdeL5yDnJYLXWt9l9lTfk';
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
