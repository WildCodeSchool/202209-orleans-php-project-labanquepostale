<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('user@email.com');
        $user->setFirstName('Teddy');
        $user->setLastName('Slexiqe');
        $user->setProfileImageName('profile.png');
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            'azerty'
        );
        $user->setPassword($hashedPassword);
        $manager->persist($user);

        $admin = new User();
        $admin->setEmail('admin@email.com');
        $admin->setFirstName('Jacky');
        $admin->setLastName('Chan');
        $admin->setRoles(['ROLE_ADMIN']);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $admin,
            'admin1234'
        );
        $admin->setPassword($hashedPassword);
        $manager->persist($admin);

        $manager->flush();
    }
}
