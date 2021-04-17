<?php

namespace App\Provider;

use App\Configuration\ApiCodeResponse;
use App\Factory\ApiResource;
use App\Service\ApiSerializer;
use Symfony\Component\HttpFoundation\JsonResponse;

class JsonApiProvider
{
    /** JSON Response parameters */
    public const CODE = 'code';
    public const MESSAGE = 'message';
    public const RESULT = 'result';
    public const ERRORS = 'errors';

    /**
     * @var ApiSerializer
     */
    private $serializer;

    /**
     * JsonApiResponse constructor.
     *
     * @param ApiSerializer $serializer
     */
    public function __construct(ApiSerializer $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * On success response
     *
     * @param ApiResource $resource
     * @return JsonResponse
     */
    public function onSuccess(ApiResource $resource): JsonResponse
    {
        $json = $this->serializer->serialize($resource->getResult(), 'json', ['group' => $resource->getGroup()]);
        $result = json_decode($json, false);

        return self::render($resource->getCode(), $resource->getMessage(), $result);
    }

    /**
     * @param int $code
     * @param string|null $message
     * @param array $result
     * @param array $errors
     * @return JsonResponse
     */
    private static function render(int $code = 200, string $message = null, array $result = [], array $errors = [])
    {
        // show default message if custom message is null
        if (null == $message && array_key_exists($code, ApiCodeResponse::MESSAGE)) {
            $message = ApiCodeResponse::MESSAGE[$code];
        }

        $data = [
            static::CODE => $code,
            static::MESSAGE => $message,
            static::RESULT => $result,
            static::ERRORS => $errors
        ];

        $json = json_encode($data, JSON_BIGINT_AS_STRING);

        $headerStatus = in_array($code, ApiCodeResponse::getDefaultStatus(), true) ? $code : 400;

        return new JsonResponse($json, $headerStatus, [], true);
    }

    /**
     * On failure response
     *
     * @param ApiResource $resource
     * @return JsonResponse
     */
    public function onFailure(ApiResource $resource): JsonResponse
    {
        return self::render($resource->getCode(), $resource->getMessage(), [], $resource->getErrors());
    }
}
