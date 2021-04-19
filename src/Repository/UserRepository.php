<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

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

    /**
     * @var TokenStorageInterface
     */
    protected $tokenStorage;

    public function __construct(
            ManagerRegistry $registry,
            TokenStorageInterface $tokenStorage,
            EntityManagerInterface $manager
    ) {
        parent::__construct($registry, User::class);
        $this->tokenStorage = $tokenStorage;
        $this->manager = $manager;
    }

    public function saveUser($data)
    {
        $newUser = new User();
        $newUser
            ->setFirstName($data['firstName'])
            ->setEmail($data['email'])
            ->setPassword($data['password'])
            ->setCin($data['cin'])
            ->setPhoneNumber($data['phoneNumber'])
            ;
        $this->manager->persist($newUser);
        $this->manager->flush();
        return $newUser;
    }

    public function updateUser($data)
    {
        $user = $this->tokenStorage->getToken()->getUser();
        $user
            ->setFirstName($data['firstName'])
            ->setPassword($data['password'])
            ->setCin($data['cin'])
            ->setPhoneNumber($data['phoneNumber'])
        ;
        $this->manager->persist($user);
        $this->manager->flush();
        return $user;
    }

    /**
     * @param User $user
     */
    public function removeUser(User $user)
    {
        $this->manager->remove($user);
        $this->manager->flush();
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
