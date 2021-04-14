<?php

namespace App\DataFixtures;

use App\Entity\Department;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Validator\Constraints\DateTime;
use \Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class DepartmentFixtures extends Fixture implements OrderedFixtureInterface
{
    public const DEPARTMENT_REFERENCE = 'department-';

    public function load(ObjectManager $manager)
    {
        for($i = 0; $i<10; $i++) {
            $department= new Department();
            $department->setName('department'.$i);
            $department->setCreatedAt(new \DatetimeImmutable());
            $department->setUpdatedAt(new \DatetimeImmutable());
            $this->setReference(self::DEPARTMENT_REFERENCE.$i, $department);
            $manager->persist($department);
            $manager->flush();
        }
    }

    /**
     *
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 2;
    }
}