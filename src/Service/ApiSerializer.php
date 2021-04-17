<?php

namespace App\Service;

use JMS\Serializer\Context;
use JMS\Serializer\SerializerInterface;
use JMS\Serializer\SerializationContext;

use function count;

class ApiSerializer
{

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * JMSSerializer constructor.
     *
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param array $data
     * @param string $format
     * @param array $options
     * @return string
     */
    public function serialize(array $data, string $format = 'json', array $options = []): string
    {
        $context = null;

        $group = $options['group'] ?? null;

        if ($group && count($group)) {
            $context = new SerializationContext();
            $context->setSerializeNull(true);
            $context->setGroups($group);
        }

        return $this->serializer->serialize($data, $format, $context);
    }
}
