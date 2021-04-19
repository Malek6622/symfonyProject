<?php

namespace App\Controller;

use App\Configuration\ApiCodeResponse;
use App\Factory\ApiResource;
use App\Form\ProductType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Provider\JsonApiProvider;
use App\Repository\ProductRepository;

class ProductController extends AbstractBaseController
{
    /**
     * @var ProductRepository
     */
    private $productRepository;

    public function __construct(
        JsonApiProvider $apiProvider,
        ProductRepository $productRepository
    ) {
        parent::__construct($apiProvider);
        $this->productRepository = $productRepository;
    }

    /**
     * @Route(path="api/product/create", name="product_create", methods={"POST"})
     */
    public function create(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $newProduct = $this->productRepository->saveProduct($data);
        if (!$newProduct) {
            return $this->getApiProvider()->onFailure(
                ApiResource::create(ApiCodeResponse::NOT_FOUND_RESOURCE, 'not found resource', [], []));
        } else {
            $responseProduct = $this->serialize($newProduct, "group1");
            return $this->getApiProvider()->onSuccess(
                ApiResource::create(ApiCodeResponse::CREATED, 'product created', [$responseProduct], []));
        }
    }

    /**
     * @Route(path="api/product/update/{id}", name="product_update", methods={"PUT"})
     */
    public function update(Request $request, int $id)
    {
        $product = $this->productRepository->findOneById($id);
        $data = json_decode($request->getContent(), true);
        $updatedProduct = $this->productRepository->updateProduct($product, $data);
        if (!$updatedProduct) {
            return $this->getApiProvider()->onFailure(
                ApiResource::create(ApiCodeResponse::NOT_FOUND_RESOURCE, 'not found resource', [], []));
        } else {
            $responseProduct = $this->serialize($updatedProduct, "group1");
            return $this->getApiProvider()->onSuccess(
                ApiResource::create(ApiCodeResponse::CREATED, 'product updated', [$responseProduct], []));
        }
    }

    /**
     * @Route(path="api/product/delete/{id}", name="product_delete", methods={"DELETE"})
     */
    public function delete(int $id)
    {
        $product = $this->productRepository->findOneById($id);
        if (!$product) {
            return $this->getApiProvider()->onFailure(
                ApiResource::create(ApiCodeResponse::NOT_FOUND_RESOURCE, 'not found resource', [], []));
        } else {
            $this->productRepository->removeProduct($product);
            return $this->getApiProvider()->onSuccess(
                ApiResource::create(ApiCodeResponse::SUCCESS, 'product deleted', [], []));
        }
    }

    /**
     * @Route(path="api/product/get/{id}", name="product_get", methods={"GET"})
     * @param int $id
     */
    public function getOneProduct(int $id)
    {
        $product = $this->productRepository->findOneById($id);
        if (!$product) {
            return $this->getApiProvider()->onFailure(
                ApiResource::create(ApiCodeResponse::NOT_FOUND_RESOURCE, 'not found resource', [], []));
        }
        else {
            $responseProduct = $this->serialize($product, "group1");
            return $this->getApiProvider()->onSuccess(
                ApiResource::create(ApiCodeResponse::SUCCESS, 'success', [$responseProduct], []));
        }
    }

    /**
     * @Route(path="/api/user/get", name="users_get", methods={"GET"})
     */
    public function getUsers()
    {
        $products = $this->productRepository->findAll();
        if (!$products) {
            return $this->getApiProvider()->onFailure(
                ApiResource::create(ApiCodeResponse::NOT_FOUND_RESOURCE, 'not found resource', [], []));
        }
        else {
            $responseProducts = [];
            foreach($products as $product) {
                $responseProduct = $this->serialize($product, "group1");
                array_push($responseProducts, $responseProduct);
            }
            return $this->getApiProvider()->onSuccess(
                ApiResource::create(ApiCodeResponse::SUCCESS, 'success', [$responseProducts], []));
        }
    }
}