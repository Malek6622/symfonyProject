<?php

namespace App\EventListener;

use App\Provider\JsonApiProvider;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AuthenticationSuccessListener
{
    /**
     * @var TokenStorageInterface
     */
    protected $tokenStorage;

    protected $apiProvider;

    public function __construct(
        TokenStorageInterface $tokenStorage,
        JsonApiProvider $apiProvider
    )
    {
        $this->tokenStorage = $tokenStorage;
        $this->apiProvider = $apiProvider;
    }

    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $userData = [];
        $userData['id'] = $this->tokenStorage->getToken()->getUser()->getId();
        $userData['email'] = $this->tokenStorage->getToken()->getUser()->getEmail();
        $userData['userName'] = $this->tokenStorage->getToken()->getUser()->getUsername();
        $userData['cin'] = $this->tokenStorage->getToken()->getUser()->getCin();
        $userData['birthDate'] = $this->tokenStorage->getToken()->getUser()->getBirthDate();
        $userData['roles'] = $this->tokenStorage->getToken()->getUser()->getRoles();
        $data['user'] = $userData;
        $data['token'] = $event->getData()['token'];
        $event->setData([
            'code' => $event->getResponse()->getStatusCode(),
            'message' =>'sucess',
            'result' => [$data]
        ]);
    }
}
