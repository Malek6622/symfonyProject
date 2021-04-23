<?php

namespace App\Controller;

use App\Configuration\ApiCodeResponse;
use App\Entity\User;
use App\Factory\ApiResource;
use App\Form\UserType;
use App\Repository\DepartmentRepository;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Provider\JsonApiProvider;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserController extends AbstractBaseController
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var DepartmentRepository
     */
    private $departmentRepository;

    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @var TokenStorageInterface
     */
    protected $tokenStorage;

    public function __construct(
        JsonApiProvider $apiProvider,
        UserRepository $userRepository,
        TokenStorageInterface $tokenStorage,
        DepartmentRepository $departmentRepository,
        ProductRepository $productRepository
    ) {
        parent::__construct($apiProvider);
        $this->userRepository = $userRepository;
        $this->departmentRepository = $departmentRepository;
        $this->tokenStorage = $tokenStorage;
        $this->productRepository = $productRepository;
    }

    /**
     * @Route(path="api/user/create", name="user_create", methods={"POST"})
     */
    public function create(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $department = $this->departmentRepository->findOneById($data['departmentId']);
        $newUser = new User();
        $newUser->setDepartment($department);
        $newUser->setRoles('ROLE_USER');

        foreach ($data['products'] as $idProduct) {
            $product = $this->productRepository->findOneById($idProduct);
            $product->addUser($newUser);
            $newUser->addProduct($product);
        }
        $this->save(UserType::class, $data, $newUser);
        $responseUser = $this->serialize($newUser, "group0");
        return $this->getApiProvider()->onSuccess(
            ApiResource::create(ApiCodeResponse::CREATED, 'user created', [$responseUser], []));

    }

    /**
     * @Route(path="api/user/update/{id}", name="user_update", methods={"PUT"})
     */
    public function update(Request $request, int $id)
    {
        $data = json_decode($request->getContent(), true);
        $department = $this->departmentRepository->findOneById($data['departmentId']);
        $updatedUser = $this->userRepository->findOneById($id);
        if (!$updatedUser) {
            return $this->getApiProvider()->onFailure(
                ApiResource::create(ApiCodeResponse::NOT_FOUND_RESOURCE, 'user not found', [], []));
        } else {
            $userProducts = $updatedUser->getProducts();
            $updatedUser->setDepartment($department);
            $updatedUser->setRoles('ROLE_USER');
            foreach ($userProducts as $userProduct) {
                $updatedUser->removeProduct($userProduct);
                $userProduct->removeUser($updatedUser);
            }
            foreach ($data['products'] as $idProduct) {
                $productToAdd = $this->productRepository->findOneById($idProduct);
                if (!$productToAdd) {
                    return $this->getApiProvider()->onFailure(
                        ApiResource::create(ApiCodeResponse::NOT_FOUND_RESOURCE, 'product not found', [], []));
                }
                else {
                    $productToAdd->addUser($updatedUser);
                    $updatedUser->addProduct($productToAdd);
                }
            }
            $this->save(UserType::class, $data, $updatedUser);
            $responseUser = $this->serialize($updatedUser, "group0");
            return $this->getApiProvider()->onSuccess(
                ApiResource::create(ApiCodeResponse::CREATED, 'user updated', [$responseUser], []));
        }
    }

    /**
     * @Route(path="api/user/delete/{id}", name="user_delete", methods={"DELETE"})
     */
    public function delete(int $id)
    {
        $user = $this->userRepository->findOneById($id);
        if (!$user) {
            return $this->getApiProvider()->onFailure(
                ApiResource::create(ApiCodeResponse::NOT_FOUND_RESOURCE, 'user not found', [], []));
        } else {
            $this->userRepository->removeUser($user);
            return $this->getApiProvider()->onSuccess(
                ApiResource::create(ApiCodeResponse::SUCCESS, 'user deleted', [], []));
        }
    }

    /**
     * @Route(path="api/user/get/{id}", name="user_get", methods={"GET"})
     * @param int $id
     */
    public function getOneUser(int $id)
    {
        $user = $this->userRepository->findOneById($id);
        if (!$user) {
            return $this->getApiProvider()->onFailure(
                ApiResource::create(ApiCodeResponse::NOT_FOUND_RESOURCE, 'user not found', [], []));
        }
        else {
            $responseUser = $this->serialize($user, "group0");
            return $this->getApiProvider()->onSuccess(
                ApiResource::create(ApiCodeResponse::SUCCESS, 'success', [$responseUser], []));
        }
    }

    /**
     * @Route(path="/api/user/get", name="users_get", methods={"GET"})
     */
    public function getUsers()
    {
        $users = $this->userRepository->findAll();
        if (!$users) {
            return $this->getApiProvider()->onFailure(
                ApiResource::create(ApiCodeResponse::NOT_FOUND_RESOURCE, 'not found resource', [], []));
        }
        else {
            $responseUsers = [];
            foreach($users as $user) {
                $responseUser = $this->serialize($user, "group0");
                array_push($responseUsers, $responseUser);
            }
            return $this->getApiProvider()->onSuccess(
                ApiResource::create(ApiCodeResponse::SUCCESS, 'success', [$responseUsers], []));
        }
    }
}
