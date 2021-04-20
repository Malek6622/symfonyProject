<?php

namespace App\Controller;

use App\Configuration\ApiCodeResponse;
use App\Factory\ApiResource;
use App\Provider\JsonApiProvider;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserProductController extends AbstractBaseController
{
    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(
        JsonApiProvider $apiProvider,
        ProductRepository $productRepository,
        UserRepository $userRepository
    )
    {
        parent::__construct($apiProvider);
        $this->productRepository = $productRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @Route(path="api/user_product/create", name="user_product_create", methods="POST")
     */
    public function create(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $user = $this->userRepository->findOneById($data['userId']);
        $product = $this->productRepository->findOneById($data['productId']);
        $product->addUser($user);
        $user->addProduct($product);
        $em = $this->getDoctrine()->getManager();
        $em->persist($product);
        $em->persist($user);
        $em->flush();
        return $this->getApiProvider()->onSuccess(
            ApiResource::create(ApiCodeResponse::CREATED, 'userProduct created', [], []));

    }

}