<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;

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
            $user->setEmail('user@gmail.com');
            $user->setUsername('user');
            $this->addReference(self::USER_REFERENCE.$i, $user);
            $user->setIdDepartment($this->getReference('department-'.$i));
            $password = $this->encoder->encodePassword($user, '123');
            $user->setPassword($password);
            //$user->setBirthDate(new Date());
            $user->setCin('142257895');
            $user->setCreatedAt(new \DatetimeImmutable());
            $user->setUpdatedAt(new \DatetimeImmutable());
            $manager->persist($user);
            $manager->flush();
    }
    }
}