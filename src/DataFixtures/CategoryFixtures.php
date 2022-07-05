<?php

namespace App\DataFixtures;


use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;


class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 25; $i++) {
            $category = new Category();
            $category->setName('category' . $i);
            $category->setCreatedAt(new \DateTimeImmutable());
            $manager->persist($category);

            $this->addReference('category' . $i, $category);
        }


        $manager->flush();
    }
}
