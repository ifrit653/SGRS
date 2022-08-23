<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\EntityListner\UserListner;

class UserFixtures extends Fixture
{


    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setFirstName('User' . $i);
            $user->setLastName('rakoto');
            $user->setEmail('User' . $i . '@gmail.com');
            $user->setRoles(['ROLE_USER']);

            $user->setPlainpassword('password');

            $manager->persist($user);
        }


        $manager->flush();
    }
}
