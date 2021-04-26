<?php

namespace App\Controller;

use App\Provider\JsonApiProvider;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

abstract class AbstractBaseController extends AbstractController
{
    /**
     * @var JsonApiProvider
     */
    private $apiProvider;

    /**
     * @var Response
     */
    private $response;

    /**
     * @var array
     */
    private $data;

    /**
     * AbstractResourceFactory constructor.
     * @param JsonApiProvider $apiProvider
     */
    public function __construct(
        JsonApiProvider $apiProvider
    ) {
        $this->apiProvider = $apiProvider;
    }

    /**
     * Get apiProvider
     *
     * @return JsonApiProvider
     */
    public function getApiProvider(): JsonApiProvider
    {
        return $this->apiProvider;
    }

    public function serialize($data, $groups)
    {
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer]);
        $response = $serializer->normalize($data, null, ['groups' => $groups]);
        return $response;
    }

    public function save($classe, $data, $object)
    {
        $form = $this->createForm($classe, $object);
        $form->submit($data);
        $em = $this->getDoctrine()->getManager();
        $em->persist($object);
        $em->flush();
    }
}