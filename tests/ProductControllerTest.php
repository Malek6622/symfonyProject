<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{
    public function getTokenUser()
    {
        return 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2MTkxNzE5NzYsImV4cCI6MTYxOTUzMTk3Niwicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoidXNlcjBAZ21haWwuY29tIn0.vxyWxovOoWV-c6XXFMygIwnKyLJYgDNwfn_0qZuF1X9iMAKWsP6hC4i9EitKmI3bZUUxWPcXmEDwiQ2HDK5CCaiLA6bapZCivU8t4mI49ZTHqlVTaskCzjYbn3CtYjf8HIj6QtsaT-uB0Kyp3YOHvCDAatxc_51vj5qOAgUzvPFV7oOb9HKLzV4WLdC39SEQgIf67MnotwMrxBqFSxpk8ibGBovfiA37pB1JZ5jVuW-RYuzPmmpiyUF-B3Rcb-49vjbiEsVmRI9uacA_I-oJq6S7N3N32Zyiqy5bge-TVvhGWWfKDNaKsJauuR6aVe6fv_9mK704hdEidhuXMfP6CiXxRqBndoGM9nPK7Zs_nYGW4fMo30TprWfCKRfdRdadvlI57Iafw4D_U99OxvAIUiZklxiGrHUXYANdgmuVoFaE91PO23mA_GxznKdKxhAQV-oBCowFeoDB1EwpIDRQYik1bhUhYNNVowZsrGajDOS7JF2CE_n3WfJGy_c7eLWIz-qXOCw6jXfpVTOrFfI8Qu_qhd9BbDmAKyF9CdGEviHs5xEZ-xy2OGs2CP65OiCDPRjXdske9dK0AICOY-2suf23iUl3B66gKwygBR8m_k13x4u-uV0WRyq4LSR-w1Y4l16HOLih4ja4iZ16Xn0wauTdeL5yDnJYLXWt9l9lTfk';
    }


    public function getTokenAdmin()
    {
        return 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2MTkxNzMyNzgsImV4cCI6MTYxOTUzMzI3OCwicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoibWFsZWtAZ21haWwuY29tIn0.bvN6em-2a3ADDWR6ebGz4iWbuXJU4APwK1GKlUoV_qHzpkYx1jy5-a18WBHhkF88RzbrL085SFjLTd8LFt5e0nk55xHDrArvoPBIgK0kL1GQVYA-0WIQzh2U0HPPanBr9y0mmPGMabwLAKJLc1q5mfwdprPSQhlgbArwuj0Plw0hZJxmMkamrQzsJXJpFHOTMtZvU2YD4D0ynBJ8ilFgISG50pY9RQLHJVlESi13ND1fzKHv607V3QWmReh46HTHAHFexAMozrrILD2_ey_gz6YxrBE7xlqOjro0G9LD86RlCYmxs3gYNv1rdw0ZEOxPaFEYxe6VWC-OsRVQshUCeBVbBdf7eSQVZ71DDXoubqfJHWLiBJI4issqykxQXZtMFPImwFRHGQnRGmU3y4roU1fTX5iC6rjKW4q7_l40ai9rkJ3m89A5rMLfOL7Z93RJZpbXL9YD32ER7zrAqfe0DfubeoFmwIBOU4MaTfDaTima_hYLXoREYkSEwxSjZkIipDWQXruUhvWljdn5_8gYYLD1lMzVVMSmHPM2xvYAsAmPtaW7wJ-y2elUAXLRnKzdJhtY9sn5AsXzFnnuwdAfVDpB_VfrUxGF8qXgt2QOwaAbNQ1C_2lZRWYQwgvK50WBGGQO0kg-LChybFhq0pD0b6R8cSTeth73wHEqYu7Y5h0';
    }

    public function testCreateProductWithUserToken()
    {
        $token = $this->getTokenUser();
        $this->client = static::createClient();
        $this->client->request(
            'POST',
            'api/admin/product/create',
            array(),
            array(),
            [
                'HTTP_AUTHORIZATION' => "{$token}",
                'CONTENT_TYPE' => 'application/json',
                'HTTP_ACCEPT' => 'application/ld+json'
            ],
            '{
                "name": "newProduct",
                "departmentId": 2
            }'
        );
        $this->assertResponseStatusCodeSame(403);
    }

    public function testCreateProductWithAdminToken()
    {
        $token = $this->getTokenAdmin();
        $this->client = static::createClient();
        $this->client->request(
            'POST',
            'api/admin/product/create',
            array(),
            array(),
            [
                'HTTP_AUTHORIZATION' => "{$token}",
                'CONTENT_TYPE' => 'application/json',
                'HTTP_ACCEPT' => 'application/ld+json'
            ],
            '{
                "name": "newProduct",
                "departmentId": 2
            }'
        );
        $this->assertResponseIsSuccessful();
        $response = $this->client->getResponse();
        $this->assertResponseStatusCodeSame(201);
        $product = json_decode($response->getContent());
    }

    public function testUpdateProductWithoutToken()
    {
        $this->client = static::createClient();
        $this->client->request(
            'PUT',
            'api/admin/product/update/3',
            array(),
            array(),
            [
                'HTTP_AUTHORIZATION' => "{}",
                'CONTENT_TYPE' => 'application/json',
                'HTTP_ACCEPT' => 'application/ld+json'
            ],
            '{
                "name": "updatedProduct",
                "departmentId": 4
            }'
        );
        $this->assertResponseStatusCodeSame(401);
    }

    public function testUpdateProductWithToken()
    {
        $token = $this->getTokenAdmin();
        $this->client = static::createClient();
        $this->client->request(
            'PUT',
            'api/admin/product/update/10',
            array(),
            array(),
            [
                'HTTP_AUTHORIZATION' => "{$token}",
                'CONTENT_TYPE' => 'application/json',
                'HTTP_ACCEPT' => 'application/ld+json'
            ],
            '{
                "name": "updatedProduct",
                "departmentId": 4
            }'
        );
        $this->assertResponseIsSuccessful();
        $response = $this->client->getResponse();
        $this->assertResponseStatusCodeSame(201);
        $product = json_decode($response->getContent());
    }

    public function testDeleteProductWithToken()
    {
        $token = $this->getTokenAdmin();
        $this->client = static::createClient();
        $this->client->request(
            'DELETE',
            'api/admin/product/delete/2',
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

    public function testGetOneProductWithToken()
    {
        $token = $this->getTokenUser();
        $this->client = static::createClient();
        $this->client->request(
            'GET',
            'api/product/get/1',
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

    public function testGetProductsWithToken()
    {
        $token = $this->getTokenUser();
        $this->client = static::createClient();
        $this->client->request(
            'GET',
            'api/product/get',
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
