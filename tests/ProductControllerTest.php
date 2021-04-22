<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{
    public function getTokenUser()
    {
        return 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2MTkxMDU2NDksImV4cCI6MTYxOTEwOTI0OSwicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoidXNlcjBAZ21haWwuY29tIn0.AUIX6wfUX81JusvjtriyO61Etb1K9aLRzWkzfXCyg8uZYpepyRc5d5qeGnVb_hEy33kk4bPySKUtD-vCSvUkki0vddqxbVWoiAo5DaCnqghD-WZ8rn-hKystCtwbo6AIkGHpyIrJvHgqERTQ2C1HWQAPUsOBMSdHVlyISDNyIiO2c6fbrnv9wA8jGYtcB85hfFh8jw1uWSVFJ0T6T5BeywWmxsTCmGttrL6JnG6Ce3KEuEdsUFTDr7v32hlG-FiExwhdd8cSHnoEtXppQQWdhFhfPARP5E6VacRUBLA96_LR81K-ONWXgNFu7VT_vNluZbU5zmNzLGcykHDr-nnFwHloxqFfpTVSlfDmz19-VJvRvvySwyph6nM3nIsE1FfNSyo44cu4ZppzwCA4J9QBL_z97pJ5N0L1TEzInQlEwQ0-7e8X3zbAW04mLzCXo78_3ajfuE-EH229ItcsGr4H0uOi4qNHV9VXX9_IdG6xyazwt9Oxbb8CowEKM5zab86KY2s8F60nEvd3casa2ox5J5jxkZSuSuUkZFyU2cMC9NrgRIMgAAg4BmhWoSedx3VVRB1SXz0eFE_5HhjcnEenBFBDXmiMqodppPI_Mc4ywV8DfJtaka81QFqn57AwS8Avb1iS1TpbU0eKkdAQzzKd5r5Xz03x87FTRC83XUd9WxU';
    }


    public function getTokenAdmin()
    {
        return 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2MTkxMDU1OTgsImV4cCI6MTYxOTEwOTE5OCwicm9sZXMiOlsiUk9MRV9BRE1JTiJdLCJ1c2VybmFtZSI6Im1hbGVrQGdtYWlsLmNvbSJ9.p0u4BPJSXSYmtjyXsUEFLVlmByeDqGaMCglzKUe4Eh7IevV5u_e65oQdEYqJGrt5t9Xh-64QpL8l555as7JwgzwF5J7Jh86BvavRWrmCbaugS6eMn5uDnZHPy4VdTJPT1WKUx6q-1ooNypE8bk8ohMZm0poYrq98dgKBwoqLvCOPMpO0ALBvPYYpKaEOlx4zvWIj02D-imP5-X40di69Aoch9u57tbnqIG5vz-uRNZLuGieOZQYqgEnWOxnJLCoFZ6Kb6r2OvtPKNIBJoF6HB1qd9tqnqz-XajsMA0BXZ_AOuYVeJImOSaOHFUVYQo5jFv6ksMVsXxN525KWfIPJwjOh3zG0z1g9z5ImzXX2WDynAMnwlUZXiRuCElEmLp_zyFbrwzNRZdEEQRUXt2NrjoyDm1dZuj1HelcMeqh1Z4NeUjB2lL6f_1_8fDD60JUsBCi_Tv8ACF-xWL_ONV9cYq28G_jsan7oh1izoO5Bpi5wcleZcbOI701gLgsBajnnC4TXvHed3vn2y1AUgYuecJePEXMtOW1bQfV8cUJaxon-ui1tGF87nQxwKpVVnU_pUyqTbT1dg5XuAaM6ZTj7d2O6Td_kYmm7iJ6YhiYZNzjV-DJloyPhpE3e5Ja7JKOjm7Al__uPds9ClEtR7z9sYOMo9YyHYUiE1-p-sT-FUS4';
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
