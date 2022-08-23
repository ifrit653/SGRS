<?php

namespace App\DataFixtures;

use App\Entity\Answer;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AnswerFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 25; $i++) {
            $answer = new Answer();
            $answer->setSolution('Quis elit deserunt voluptate cupidatat occaecat labore non minim non adipisicing enim nulla. Aliquip cupidatat fugiat dolore exercitation consequat sit exercitation nulla tempor cupidatat velit sunt esse proident. Voluptate fugiat consectetur culpa occaecat anim laborum. Sit dolore eu cillum eiusmod minim irure dolor. Voluptate velit ad ad sit esse id ex aute eu fugiat enim Lorem aute et.');
            $answer->setComplaint($this->getReference('complaint' . $i));
            $manager->persist($answer);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ComplaintFixtures::class
        ];
    }
}
