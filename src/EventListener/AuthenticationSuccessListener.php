<?php

namespace App\EventListener;

use App\Configuration\ApiCodeResponse;
use App\Factory\ApiResource;
use App\Provider\JsonApiProvider;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactoryInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class AuthenticationSuccessListener
{
    /**
     * @var TokenStorageInterface
     */
    protected $tokenStorage;

    protected $apiProvider;

    public $classMetadataFactory;

    public function __construct(
        TokenStorageInterface $tokenStorage,
        JsonApiProvider $apiProvider,
        ClassMetadataFactoryInterface  $classMetadataFactory
    )
    {
        $this->tokenStorage = $tokenStorage;
        $this->apiProvider = $apiProvider;
        $this->classMetadataFactory = $classMetadataFactory;
    }

    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $data = [];
        $data['id'] = $this->tokenStorage->getToken()->getUser()->getId();
        $data['email'] = $this->tokenStorage->getToken()->getUser()->getEmail();
        $data['userName'] = $this->tokenStorage->getToken()->getUser()->getUsername();
        $data['cin'] = $this->tokenStorage->getToken()->getUser()->getCin();
        $data['birthDate'] = $this->tokenStorage->getToken()->getUser()->getBirthDate();
        $data['roles'] = $this->tokenStorage->getToken()->getUser()->getRoles();
        $token = $event->getData();
        $event->setData([
            'code' => $event->getResponse()->getStatusCode(),
            'user' => $data,
            'token' => $token['token']
        ]);
//        $response['token'] = $event->getData();
//        $normalizer = new ObjectNormalizer($classMetadataFactory);
//        $serializer = new Serializer([$normalizer]);
//        $response['user'] = $serializer->normalize($this->tokenStorage->getToken()->getUser(), null, ['groups' => "group0"]);
//        return $this->getApiProvider()->onSuccess(
//            ApiResource::create(ApiCodeResponse::SUCCESS, 'success', [$response], []));
    }
}
