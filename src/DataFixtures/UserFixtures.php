<?php

namespace App\DataFixtures;

use App\Entity\User;
use Symfony\Component\Filesystem\Filesystem;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private Filesystem $filesystem;

    public function __construct(private UserPasswordHasherInterface $passwordHasher, Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }
    public function load(ObjectManager $manager): void
    {
        $this->filesystem->remove(__DIR__ . '/../../public/uploads/userImages/');
        $this->filesystem->mkdir(__DIR__ . '/../../public/uploads/userImages/');

        copy(
            './src/DataFixtures/userImages/profile.png',
            __DIR__ . '/../../public/uploads/userImages/profile.png'
        );

        $user = new User();
        $user->setEmail('user@email.com');
        $user->setFirstName('Teddy');
        $user->setLastName('Andria');
        $user->setProfileImageName('profile.png');
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            'azerty'
        );
        $user->setPassword($hashedPassword);
        $manager->persist($user);

        $admin = new User();
        $admin->setEmail('admin@email.com');
        $admin->setFirstName('Grégory');
        $admin->setLastName('Silvestri');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setProfileImageName('profile.png');
        $hashedPassword = $this->passwordHasher->hashPassword(
            $admin,
            'admin1234'
        );
        $admin->setPassword($hashedPassword);
        $manager->persist($admin);

        $manager->flush();
    }
}
