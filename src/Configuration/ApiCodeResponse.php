<?php

namespace App\Configuration;

class ApiCodeResponse
{
    /** Default success status code */
    public const SUCCESS = 200;
    public const CREATED = 201;

    /** Default failed status code */
    public const UNAUTHORIZED_ACCESS = 401;
    public const ACCESS_DENIED = 403;
    public const NOT_FOUND_RESOURCE = 404;
    public const INTERNAL_ERROR = 500;
    /** User status code */
    public const INVALID_PARAMETERS = 1000;
    public const BAD_CREDENTIALS = 1001;
    public const EXPIRED_TOKEN = 1002;

    /**
     * Get default status
     *
     * @return array
     */
    public static function getDefaultStatus(): array
    {
        return [
            static::SUCCESS,
            static::CREATED,
            static::UNAUTHORIZED_ACCESS,
            static::ACCESS_DENIED,
            static::NOT_FOUND_RESOURCE,
            static::INTERNAL_ERROR,
        ];
    }
}

