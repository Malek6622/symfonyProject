<?php

namespace App\Controller;

use App\Configuration\ApiCodeResponse;
use App\Entity\Department;
use App\Factory\ApiResource;
use App\Form\DepartmentType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Provider\JsonApiProvider;
use App\Repository\DepartmentRepository;

class DepartmentController extends AbstractBaseController
{
    /**
     * @var DepartmentRepository
     */
    private $departmentRepository;

    public function __construct(
        JsonApiProvider $apiProvider,
        DepartmentRepository $departmentRepository
    )
    {
        parent::__construct($apiProvider);
        $this->departmentRepository = $departmentRepository;
    }

    /**
     * @Route(path="api/department/create", name="department_create", methods={"POST"})
     */
    public function create(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $newDepartment = new Department();
        $form = $this->createForm(DepartmentType::class, $newDepartment);
        $form->submit($data);
        $em = $this->getDoctrine()->getManager();
        $em->persist($newDepartment);
        $em->flush();
        if (!$newDepartment) {
            return $this->getApiProvider()->onFailure(
                ApiResource::create(ApiCodeResponse::NOT_FOUND_RESOURCE, 'not found resource', [], []));
        } else {
            $responseDepartment = $this->serialize($newDepartment, "group2");
            return $this->getApiProvider()->onSuccess(
                ApiResource::create(ApiCodeResponse::CREATED, 'product created', [$responseDepartment], []));
        }
    }

    /**
     * @Route(path="api/department/update/{id}", name="department_update", methods={"PUT"})
     */
    public function update(Request $request, int $id)
    {
        $updatedDepartment = $this->departmentRepository->findOneById($id);
        $data = json_decode($request->getContent(), true);
        $form = $this->createForm(DepartmentType::class, $updatedDepartment);
        $form->submit($data);
        $em = $this->getDoctrine()->getManager();
        $em->persist($updatedDepartment);
        $em->flush();
        if (!$updatedDepartment) {
            return $this->getApiProvider()->onFailure(
                ApiResource::create(ApiCodeResponse::NOT_FOUND_RESOURCE, 'not found resource', [], []));
        } else {
            $responseDepartment = $this->serialize($updatedDepartment, "group2");
            return $this->getApiProvider()->onSuccess(
                ApiResource::create(ApiCodeResponse::CREATED, 'product updated', [$responseDepartment], []));
        }
    }

    /**
     * @Route(path="api/department/delete/{id}", name="department_delete", methods={"DELETE"})
     */
    public function delete(int $id)
    {
        $department = $this->departmentRepository->findOneById($id);
        if (!$department) {
            return $this->getApiProvider()->onFailure(
                ApiResource::create(ApiCodeResponse::NOT_FOUND_RESOURCE, 'not found resource', [], []));
        } else {
            $this->departmentRepository->removeDepartment($department);
            return $this->getApiProvider()->onSuccess(
                ApiResource::create(ApiCodeResponse::SUCCESS, 'product deleted', [], []));
        }
    }

    /**
     * @Route(path="api/department/get/{id}", name="departments_get", methods={"GET"})
     * @param int $id
     */
    public function getOneDepartment(int $id)
    {
        $department = $this->departmentRepository->findOneById($id);
        if (!$department) {
            return $this->getApiProvider()->onFailure(
                ApiResource::create(ApiCodeResponse::NOT_FOUND_RESOURCE, 'not found resource', [], []));
        }
        else {
            $responseDepartment = $this->serialize($department, "group2");
            return $this->getApiProvider()->onSuccess(
                ApiResource::create(ApiCodeResponse::SUCCESS, 'success', [$responseDepartment], []));
        }
    }

    /**
     * @Route(path="/api/department/get", name="department_get", methods={"GET"})
     */
    public function getDepartments()
    {
        $departments = $this->departmentRepository->findAll();
        if (!$departments) {
            return $this->getApiProvider()->onFailure(
                ApiResource::create(ApiCodeResponse::NOT_FOUND_RESOURCE, 'not found resource', [], []));
        }
        else {
            $responseDepartments = [];
            foreach($departments as $department) {
                $responseDepartment = $this->serialize($department, "group2");
                array_push($responseDepartments, $responseDepartment);
            }
            return $this->getApiProvider()->onSuccess(
                ApiResource::create(ApiCodeResponse::SUCCESS, 'success', [$responseDepartments], []));
        }
    }
}
