<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Entity\Birthday;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher){
        $this->userPasswordHasher = $userPasswordHasher;
    }



    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
