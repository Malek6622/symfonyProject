<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    public function __construct(
            ManagerRegistry $registry,
            EntityManagerInterface $manager
    ) {
        parent::__construct($registry, User::class);
        $this->manager = $manager;
    }

    /**
     * @param User $user
     */
    public function removeUser(User $user)
    {
        $this->manager->remove($user);
        $this->manager->flush();
    }

    /**
     * @param $userId
     * @return int|mixed[]|string
     */
    public function findProductIds($userId)
    {
        return $this->createQueryBuilder('u')
            ->leftJoin('u.products', 'product')
            ->select('product.id')
            ->where('u.id = :val')
            ->setParameter('val', $userId)
            ->getQuery()
            ->getArrayResult()
            ;
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
