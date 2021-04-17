<?php

namespace App\Controller;

use App\Configuration\ApiCodeResponse;
use App\Factory\ApiResource;
use App\Provider\JsonApiProvider;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactoryInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use App\Controller\AbstractBaseController;

class AuthController extends AbstractBaseController
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    private $apiProvider;

    private $classMetadataFactory;

    public function __construct(
        TokenStorageInterface $tokenStorage,
        JsonApiProvider $apiProvider,
        ClassMetadataFactoryInterface $classMetadataFactory
    )
    {
        parent::__construct($apiProvider);
        $this->tokenStorage = $tokenStorage;
        $this->apiProvider = $apiProvider;
        $this->classMetadataFactory = $classMetadataFactory;
    }

    /**
     * @Route("/login_check", name="login")
     */
    public function getTokenUser(UserInterface $user, JWTTokenManagerInterface $JWTManager, ClassMetadataFactoryInterface $classMetadataFactory): JsonResponse
    {

        $response['token'] = $JWTManager->create($user);
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer]);
        $response['user'] = $serializer->normalize($user, null, ['groups' => "group0"]);
        return $this->getApiProvider()->onSuccess(
            ApiResource::create(ApiCodeResponse::SUCCESS, 'success', [$response], []));
    }
}
