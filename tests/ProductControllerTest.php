<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{
    public function getTokenUser()
    {
        return 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2MTkwOTg3NzUsImV4cCI6MTYxOTEwMjM3NSwicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoidXNlcjBAZ21haWwuY29tIn0.HdPLf3tYoL3atuFjVTqIzGhbAeO1JWl5Xw7uRB22BHdmO_Rhsjaecm4HHWgzLlmUyFo4uXDpOxjxsxRPm2ZlV52uam1ncxvN3X4b-JR4YEMpUNQTPMX5roVBaMGWn90bLYiCk-LsNVeORYudAgHLvkrSe6_vHom4WRPZTC9ZhRTgVKHu4zngwCIs-ZOkdd0y0QjMflCENkDVh1FxxIF49PMXD-KFXBn9glfe4WbItR_Y39dec9y30MSWb-o-zKylFaGNu2UCD5ifExzcGAfCDTAKEN5Jm13FQ4avY13tAbYeISTKH6nxN5R26gypPV5iWFdh2EoeIRIFPr-1RX-rUIJ0LPFK_DSKU6FEj7Mo8Pth9NSpTXx7eyqhM_YAz9B_3_2UjJD7D-Og835n3BB8dezjawOd2VkDfgiA4w1161bBS7R4LDQpyrioAd5KQJExgcf0fqMynYnWkaUPxr-amFStB9R3pLMO4XYE-9zt0Y-9qxu8MpA3PR1mVx__9whyeOoRBxAibYW2k6wOsbPBzyWiWggzOL_KqbgZ1tBoKrt7IMIlBx4uXyV3LGXE1I2CkoBoSud3a2d8YVBipWrWYlIDwZk5-2SMcI1q-QEIAKSbGS0JGqiyll6QOZqHVReWE0qPSz3EC4iwuY0qZPEe42H4b8hp40ab0ZklNc-FrjI';}


    public function getTokenAdmin()
    {
        return 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2MTkwOTkwMjIsImV4cCI6MTYxOTEwMjYyMiwicm9sZXMiOlsiUk9MRV9BRE1JTiJdLCJ1c2VybmFtZSI6Im1hbGVrQGdtYWlsLmNvbSJ9.ltT0BXFgOJ4n5UNpcf2a-a1U3Rnu24QQb9y-URGYA6Whx-7vlfB-KxOexTQsjLMqo-X4zU3BEK3hPL4FB54db2k4eozXEVPX9eK0nWnWczNanquMtkY7ARg4qfMneS0lRwJwp5x_0qX7Pcya_uXkuhEgV2dBvwRjCWX6Omf5Qo9YN_VMV-b1FafkEr5CbpeAoML9T-XrbnuAUg5vZe4EByUdegwAWnWw2FEuYny8vRrJ6gry1Ue3zsh9y_kXUWk0PWxnv2np1FnZ-Kz8AlrDyBlsuSvVDn8vzvWcXhsBMJ3iq05mm8Ax-SvZUkzHayNusQhKnRTRI9A-w-yG6eDYNkHfIuPVydiROwdbQq4tz-ASsm5sSuIKFP8SVJHE_W3VvMnzP6WnMDO-Ue5ax1XTT55SN_GlnUGVGjQkcfW8TpRXw594qCRcdqas5IPyIZvVLxynHxZDs04U1Whk5deMBJ_S0l64zqD9z7HsXQpnSYZn8gKEo2Ca-yUyKdZa_BNYikpGyBvbg-fftIsvp_6d5qdegzEUE2F_7nKx7NSHqeAF2c_nbpBj-W3LsSASBqAVqjgG2eL0rCTYihrquInK9DFjrS9JexfEty8t9u5TIIOPHuNmrKYdhr-yLPokj2u5wDDEqHsBYspsWQ4xYpT4laC0_bRVmLF1VSEtloudLEs';
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
