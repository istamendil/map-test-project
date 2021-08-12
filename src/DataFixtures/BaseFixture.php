<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Here should be everything that may be needed at site starting to work point.
 */
class BaseFixture extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);
    }

    protected function loadUsers(ObjectManager $manager){
        $user = new User();
        $user->setEmail('admin@example.com');
        $user->setFullname('John Doe');
        $user->setNickname('Admin');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword($this->passwordHasher->hashPassword($user,'admin'));
        $manager->persist($user);
        $manager->flush();
    }
}
