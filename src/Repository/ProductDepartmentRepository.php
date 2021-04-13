<?php

namespace App\Repository;

use App\Entity\ProductDepartment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProductDepartment|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductDepartment|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductDepartment[]    findAll()
 * @method ProductDepartment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductDepartmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductDepartment::class);
    }

    // /**
    //  * @return ProductDepartement[] Returns an array of ProductDepartement objects
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
    public function findOneBySomeField($value): ?ProductDepartement
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
