<?php

namespace App\Repository;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\Constraints\Date;

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

    /**
     * @param $data
     * @return User
     */
    public function saveUser($data, $department)
    {
        $newUser = new User();
        $newUser->setBirthDate(new \DateTime($data['birthDate']));
        $newUser
            ->setIdDepartment($department)
            ->setFirstName($data['firstName'])
            ->setEmail($data['email'])
            ->setPassword($data['password'])
            ->setCin($data['cin'])
            ->setPhoneNumber($data['phoneNumber'])
            ;
        $form = $this->createForm(UserType::class, $newUser);
        $this->manager->persist($newUser);
        $this->manager->flush();
        return $newUser;
    }

    /**
     * @param $data
     * @return string|\Stringable|\Symfony\Component\Security\Core\User\UserInterface
     */
    public function updateUser($data)
    {
        $user = $this->tokenStorage->getToken()->getUser();
        $user->setBirthDate(new \DateTime($data['birthDate']));
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
