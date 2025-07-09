<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private array $users = [
        [
            'email' => 'user@example.com',
            'password' => 'stronger',
        ],
        [
            'email' => 'admin@gmail.com',
            'password' => 'admin',
        ],
        [
            'email' => 'doston@karimov.com',
            'password' => 'dostonKarimov',
        ]
    ];

    public function __construct(private UserPasswordHasherInterface $passwordEncoder)
    {
    }

    public function load(ObjectManager $manager): void
    {

        foreach ($this->users as $userItem) {
            $user = new User();
            $user->setEmail($userItem['email']);
            $hashedPassword = $this->passwordEncoder->hashPassword($user, $userItem['password']);
            $user->setPassword($hashedPassword);
            $user->setRoles(['ROLE_ADMIN']);
            $user->setCreatedAt(new \DateTime('now'));

            $manager->persist($user);
        }

        $manager->flush();
    }
}
