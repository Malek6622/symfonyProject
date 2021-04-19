<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    public function __construct(
        ManagerRegistry $registry,
        EntityManagerInterface $manager
    )
    {
        parent::__construct($registry, Product::class);
        $this->manager = $manager;
    }

    /**
     * @param $data
     * @return Product
     */
    public function saveProduct($data)
    {
        $newProduct = new Product();
        $newProduct
            ->setName(($data['name']))
        ;
        $this->manager->persist($newProduct);
        $this->manager->flush();
        return $newProduct;
    }

    /**
     * @param $product
     * @param $data
     * @return mixed
     */
    public function updateProduct($product, $data)
    {
        $product
            ->setName(($data['name']))
        ;
        $this->manager->persist($product);
        $this->manager->flush();
        return $product;
    }

    /**
     * @param Product $product
     */
    public function removeProduct(Product $product)
    {
        $this->manager->remove($product);
        $this->manager->flush();
    }

    // /**
    //  * @return Product[] Returns an array of Product objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
