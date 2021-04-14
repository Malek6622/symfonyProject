<?php

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AuthenticationSuccessListener
{
    /**
     * @var TokenStorageInterface
     */
    protected $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $data = [];
        $user = $this->tokenStorage->getToken()->getUser();
        $data['email'] = $user->getEmail();
        $data['userName'] =  $user->getUsername();
        $data['cin'] = $user->getCin();
        $data['phoneNumber'] = $user->getPhoneNumber();
        $token = $event->getData();
        $event->setData([
            'user' => $data,
            'token' => $token['token']
        ]);
    }
}
