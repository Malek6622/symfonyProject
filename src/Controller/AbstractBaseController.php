<?php

namespace App\Controller;

use App\Provider\JsonApiProvider;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractBaseController
{
    /**
     * @var JsonApiProvider
     */
    private $apiProvider;

    /**
     * @var Response
     */
    private $response;

    /**
     * @var array
     */
    private $data;

    /**
     * AbstractResourceFactory constructor.
     * @param JsonApiProvider $apiProvider
     */
    public function __construct(
        JsonApiProvider $apiProvider
    ) {
        $this->apiProvider = $apiProvider;
    }

    /**
     * Get apiProvider
     *
     * @return JsonApiProvider
     */
    public function getApiProvider(): JsonApiProvider
    {
        return $this->apiProvider;
    }

    /**
     * Get response
     *
     * @return Response
     */
    public function getResponse(): Response
    {
        return $this->response;
    }

    /**
     * Set response
     *
     * @param Response $response
     */
    public function setResponse(Response $response): void
    {
        $this->response = $response;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData(): ?array
    {
        return $this->data;
    }

    /**
     * Set data
     *
     * @param array $data
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }
}