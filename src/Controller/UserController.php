<?php

namespace App\Controller;

use App\Configuration\ApiCodeResponse;
use App\Factory\ApiResource;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Provider\JsonApiProvider;
use App\Repository\UserRepository;

class UserController extends AbstractBaseController
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public $classMetadataFactory;

    public function __construct(
        JsonApiProvider $apiProvider,
        UserRepository $userRepository
    ) {
        parent::__construct($apiProvider);
        $this->userRepository = $userRepository;
    }

    /**
     * @Route(path="api/user/create", name="user_create", methods={"POST"})
     */
    public function create(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $newUser = $this->userRepository->saveUser($data);
        if (!$newUser) {
            return $this->getApiProvider()->onFailure(
                ApiResource::create(ApiCodeResponse::NOT_FOUND_RESOURCE, 'not found resource', [], []));
        } else {
            $responseUser = $this->serialize($newUser, "group0");
            return $this->getApiProvider()->onSuccess(
                ApiResource::create(ApiCodeResponse::CREATED, 'user created', [$responseUser], []));
        }
    }

    /**
         * @Route(path="api/user/update", name="user_update", methods={"PUT"})
     */
    public function update(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $updatedUser = $this->userRepository->updateUser($data);
        if (!$updatedUser) {
            return $this->getApiProvider()->onFailure(
                ApiResource::create(ApiCodeResponse::NOT_FOUND_RESOURCE, 'not found resource', [], []));
        } else {
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
                ApiResource::create(ApiCodeResponse::NOT_FOUND_RESOURCE, 'not found resource', [], []));
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
                ApiResource::create(ApiCodeResponse::NOT_FOUND_RESOURCE, 'not found resource', [], []));
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