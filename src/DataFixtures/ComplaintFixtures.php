<?php

namespace App\DataFixtures;

use App\Entity\Complaint;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ComplaintFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 25; $i++) {
            $complaint = new Complaint();
            $complaint->setProblem('Quis elit deserunt voluptate cupidatat occaecat labore non minim non adipisicing enim nulla. Aliquip cupidatat fugiat dolore exercitation consequat sit exercitation nulla tempor cupidatat velit sunt esse proident. Voluptate fugiat consectetur culpa occaecat anim laborum. Sit dolore eu cillum eiusmod minim irure dolor. Voluptate velit ad ad sit esse id ex aute eu fugiat enim Lorem aute et.');
            $complaint->setStatus('pending');
            $complaint->setCategory($this->getReference('category' . $i));
            $manager->persist($complaint);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CategoryFixtures::class
        ];
    }
}
