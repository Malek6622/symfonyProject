<?php

namespace App\Repository;

use App\Entity\Department;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Department|null find($id, $lockMode = null, $lockVersion = null)
 * @method Department|null findOneBy(array $criteria, array $orderBy = null)
 * @method Department[]    findAll()
 * @method Department[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DepartmentRepository extends ServiceEntityRepository
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
        parent::__construct($registry, Department::class);
        $this->manager = $manager;
    }

    /**
     * @param $data
     * @return Department
     */
    public function saveDepartment($data)
    {
        $newDepartment = new Department();
        $newDepartment
            ->setName(($data['name']))
        ;
        $this->manager->persist($newDepartment);
        $this->manager->flush();
        return $newDepartment;
    }

    /**
     * @param $department
     * @param $data
     * @return mixed
     */
    public function updateDepartment($department, $data)
    {
        $department
            ->setName(($data['name']))
        ;
        $this->manager->persist($department);
        $this->manager->flush();
        return $department;
    }

    /**
     * @param Department $department
     */
    public function removeDepartment(Department $department)
    {
        $this->manager->remove($department);
        $this->manager->flush();
    }

    // /**
    //  * @return Departement[] Returns an array of Departement objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Departement
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
