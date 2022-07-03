<?php

namespace App\DataFixtures;

use App\Entity\Complaint;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ComplaintFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $complaint = new Complaint();
        $complaint->setProblem('Quis elit deserunt voluptate cupidatat occaecat labore non minim non adipisicing enim nulla. Aliquip cupidatat fugiat dolore exercitation consequat sit exercitation nulla tempor cupidatat velit sunt esse proident. Voluptate fugiat consectetur culpa occaecat anim laborum. Sit dolore eu cillum eiusmod minim irure dolor. Voluptate velit ad ad sit esse id ex aute eu fugiat enim Lorem aute et.');
        $complaint->setStatus('pending');
        $manager->persist($complaint);
        $manager->flush();
    }
}
