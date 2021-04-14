<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Validator\Constraints\DateTime;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    public const PRODUCT_REFERENCE = 'product-';

    public function load(ObjectManager $manager)
    {
        for($i = 0; $i<10; $i++) {
            $product= new Product();
            $this->addReference(self::PRODUCT_REFERENCE.$i, $product);
            $product->addUser($this->getReference('user-'.$i));
            $product->setName('product');
            $product->setDepartmentId(null);
            $product->setCreatedAt(new \DatetimeImmutable());
            $product->setUpdatedAt(new \DatetimeImmutable());
            $product->setDepartmentId($this->getReference('department-'.$i));
            $manager->persist($product);
            $manager->flush();
        }
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class
        );
    }
}