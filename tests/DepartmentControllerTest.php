<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DepartmentControllerTest extends WebTestCase
{
    public function getTokenUser()
    {
        return 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2MTk0MjcyMzcsImV4cCI6MTYxOTc4NzIzNywicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoidXNlcjBAZ21haWwuY29tIn0.16_tfZuxLkCCuPdA-M917KLpZIL3UGzkK_zFB7lpI1Gv0gBJZjgmlbJFSei_H17PyOGeXQraPmWOlKRQ-kFCvAdiyMtkiz79tB-OXwOs6Kb_qnu5H4j5pxVTN_SxrwS1Z9uox_5ZUxCI9hrDdcm5MqmP5reiurGKswAycdyOpzHOfHL4qcpqtcT3HO3GtdxDPEF0HavrtsUSIyszEPVmXgu4cJODZiRR1nLK_XAQzFNoQetOXQ4Rz5XPIyRrKlJ9d_6fTca0nFHs57fUsGuZ8SHd9UbV2NqgEi0UHwPM-V4kDFg9BRlfBEvviMhc2Kl2bHPKaHFIfviOwI-_otlcOiynsyZ9EtmTmG9TqhU8AdmawKtN0YKX9bMxyGVS6bU27vMgb_0cDtg3aoJW4yqkxixHTaDlrTVnbiY3MscIXF2Jc1L0EnwDo_k0RTGCBHMldtk9GjD4wA7Po8ps_AzEAhDSXA_SVIrhQflr4Ma2tbzLMNomHcWrcoaIUp844H_BMREA9dtackdopqoajUzvIJgbKgAgfYGD_FLBqrPXnHLpXreFybXB4HREPk4U3YXhChRZ5BAVgcIzJzXtMH8aiKCN0uXxb39BclUCUZwHntP8PqSVNmN2jIdMw7qgDrf-HTqWFYDJOcbNH1o1RCk2OQfc9i0dzYdf_dFjhZcjAN4';
    }

    public function getTokenAdmin()
    {
        return 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2MTk0MjcxNzMsImV4cCI6MTYxOTc4NzE3Mywicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoibWFsZWtAZ21haWwuY29tIn0.du42vxg7YIZBeshGVFxIQ7V6kuMjBAtjaPyp_R9Ooa4mOQguDDCLwMs35q-cjuZO47N7-DDJ2T1_a7CU8auRwenbrGtOGU1WJZ4b0dIpgV73XbTur_-qbn1kuPyLoGW3B_2n-WRkH-nXbA3Q7KfIK-XYvdZVduWIE8UTH1DIXJJix9XXXv0tM7DU3EGzTQhGxoTF6U9GCNAQ0fdh0LCAYQ0TCAv1iEdL7kVpX0dBQR459fION6HXC77iF0tgLap8O9lv635IdkbdggVHBsxmOluVMauEZDCzTWo8PWUdftSQMipP8iMxzYTQ5pJGcE9JqFE2FKhE-lAweQDJK2JNTGunhMt83yN3r3mnt02oroDhDi0rUE4gMwUsTsJQK_IWBtr8UZ5vwE8O_R88eScAqyQ-6xeMNVtkKQedSvngWd_ljSqYWJMZi9WKQRP_mK8ppd3GlZZRoDS_2aqqhoxcqnheAduPfqidNl39qjsVS5DR6FmgPi1VeyoYZl-yjI7_sCiAlqOXu7pU2ljJGtim64QJ8jjKXZ1hEmKhgFZD8I7vSqcDymS7VDmQq5lGqDwiDXrJ-J86f-cdDB9iN6RTlnPppyM8T5VTFSur-pzvXMxXHgPAaRQJR1vb5iDvJ6usbHciR-l6RsA5zPO1pScGV9vViwQ6JHocxS4BvxMD0mA';
    }

    public function testCreateDepartmentWithToken()
    {
        $token = $this->getTokenAdmin();
        $this->client = static::createClient();
        $this->client->request(
            'POST',
            'api/admin/department/create',
            array(),
            array(),
            [
                'HTTP_AUTHORIZATION' => "{$token}",
                'CONTENT_TYPE' => 'application/json',
                'HTTP_ACCEPT' => 'application/ld+json'
            ],
            '{
                "name": "newDepartment"
            }'
        );
        $this->assertResponseIsSuccessful();
        $response = $this->client->getResponse();
        $this->assertResponseStatusCodeSame(201);
        $department = json_decode($response->getContent());
    }

    public function testUpdateDepartmentWithToken()
    {
        $token = $this->getTokenAdmin();
        $this->client = static::createClient();
        $this->client->request(
            'PUT',
            'api/admin/department/update/10',
            array(),
            array(),
            [
                'HTTP_AUTHORIZATION' => "{$token}",
                'CONTENT_TYPE' => 'application/json',
                'HTTP_ACCEPT' => 'application/ld+json'
            ],
            '{
                "name": "updatedDepartment"
            }'
        );
        $this->assertResponseIsSuccessful();
        $response = $this->client->getResponse();
        $this->assertResponseStatusCodeSame(201);
        $department = json_decode($response->getContent());
    }

    public function testDeleteDepartmentWithUserToken()
    {
        $token = $this->getTokenUser();
        $this->client = static::createClient();
        $this->client->request(
            'DELETE',
            'api/admin/department/delete/3',
            array(),
            array(),
            [
                'HTTP_AUTHORIZATION' => "{$token}",
                'CONTENT_TYPE' => 'application/json',
                'HTTP_ACCEPT' => 'application/ld+json'
            ]
        );
        $this->assertResponseStatusCodeSame(403);
    }

    public function testDeleteDepartmentWithToken()
    {
        $token = $this->getTokenAdmin();
        $this->client = static::createClient();
        $this->client->request(
            'DELETE',
            'api/admin/department/delete/3',
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

    public function testGetOneDepartmentWithToken()
    {
        $token = $this->getTokenUser();
        $this->client = static::createClient();
        $this->client->request(
            'GET',
            'api/department/get/3',
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

    public function testGetDepartmentWithToken()
    {
        $token = $this->getTokenUser();
        $this->client = static::createClient();
        $this->client->request(
            'GET',
            'api/department/get',
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

    public function testGetDepartmentWithoutToken()
    {
        $this->client = static::createClient();
        $this->client->request(
            'GET',
            'api/department/get',
            array(),
            array(),
            [
                'HTTP_AUTHORIZATION' => "{}",
                'CONTENT_TYPE' => 'application/json',
                'HTTP_ACCEPT' => 'application/ld+json'
            ]
        );
        $this->assertResponseStatusCodeSame(401);
    }
}