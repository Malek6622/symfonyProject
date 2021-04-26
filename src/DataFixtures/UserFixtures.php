<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;

class UserFixtures extends Fixture
{
    private $encoder;

    public const USER_REFERENCE = 'user-';

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        for($i = 0; $i<10; $i++) {
            $user = new User();
            $user->setEmail('user'.$i.'@gmail.com');
            $user->setFirstName('user'.$i);
            $this->addReference(self::USER_REFERENCE.$i, $user);
            $user->setIdDepartment($this->getReference('department-'.$i));
            $user->setPassword('123');
            $user->setCin('142257895');
            $user->setRoles('ROLE_USER');
            $user->setCreatedAt(new \DatetimeImmutable());
            $user->setUpdatedAt(new \DatetimeImmutable());
            $manager->persist($user);
            $manager->flush();
    }
    }
}