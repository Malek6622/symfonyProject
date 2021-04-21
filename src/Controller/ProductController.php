<?php

namespace App\Controller;

use App\Configuration\ApiCodeResponse;
use App\Entity\Product;
use App\Factory\ApiResource;
use App\Form\DepartmentType;
use App\Form\ProductType;
use App\Repository\DepartmentRepository;
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

    /**
     * @var DepartmentRepository
     */
    private $departmentRepository;

    public function __construct(
        JsonApiProvider $apiProvider,
        ProductRepository $productRepository,
        DepartmentRepository $departmentRepository
    ) {
        parent::__construct($apiProvider);
        $this->productRepository = $productRepository;
        $this->departmentRepository = $departmentRepository;
    }

    /**
     * @Route(path="api/admin/product/create", name="product_create", methods={"POST"})
     */
    public function create(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $department = $this->departmentRepository->findOneById($data['departmentId']);
        $newProduct = new Product();
        $form = $this->createForm(ProductType::class, $newProduct);
        $form->submit($data);
        $newProduct->setDepartmentId($department);
        $em = $this->getDoctrine()->getManager();
        $em->persist($newProduct);
        $em->flush();
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
     * @Route(path="api/admin/product/update/{id}", name="product_update", methods={"PUT"})
     */
    public function update(Request $request, int $id)
    {
        $data = json_decode($request->getContent(), true);
        $updatedProduct = $this->productRepository->findOneById($id);
        $department = $this->departmentRepository->findOneById($data['departmentId']);
        $form = $this->createForm(ProductType::class, $updatedProduct);
        $form->submit($data);
        $updatedProduct->setDepartmentId($department);
        $em = $this->getDoctrine()->getManager();
        $em->persist($updatedProduct);
        $em->flush();
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
     * @Route(path="api/admin/product/delete/{id}", name="product_delete", methods={"DELETE"})
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
     * @Route(path="/api/product/get", name="products_get", methods={"GET"})
     */
    public function getProducts()
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
