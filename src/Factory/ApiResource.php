<?php

namespace App\Factory;

class ApiResource
{
    /**
     * @var int
     **/
    private $code;

    /**
     * @var string
     */
    private $message;

    /**
     * @var array
     */
    private $result;

    /**
     * @var array
     */
    private $errors;

    /**
     * @var array
     */
    private $group;

    /**
     * @param int|null $code
     * @param string|null $message
     * @param array $result
     * @param array $errors
     * @param array $group
     * @return self
     */
    public static function create(
        int $code = null,
        string $message = null,
        array $result = [],
        array $errors = [],
        array $group = []
    ): self {
        $resource = new self();

        $resource->code = $code;
        $resource->message = $message;
        $resource->result = $result;
        $resource->errors = $errors;
        $resource->group = $group;
        return $resource;
    }

    /**
     * Get code
     *
     * @return int
     */
    public function getCode(): ?int
    {
        return $this->code;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * Get result
     *
     * @return array
     */
    public function getResult(): array
    {
        return $this->result;
    }

    /**
     * Get errors
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Get group
     *
     * @return array
     */
    public function getGroup(): array
    {
        return $this->group;
    }
}
