<?php

namespace App\DataFixtures;

use App\Component\User\UserFactory;
use App\Entity\Company;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    private array $users = [
        [
            'email' => 'user@example.com',
            'password' => 'stronger',
            'company' => 'USER_COMPANY',
        ],
        [
            'email' => 'admin@gmail.com',
            'password' => 'admin',
            'company' => 'ADMIN_COMPANY',
        ]
    ];

    public function __construct(private UserPasswordHasherInterface $passwordEncoder, private UserFactory $userFactory)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $company = $this->getReference(CompanyFixtures::COMPANY, Company::class);

        foreach ($this->users as $userItem) {
            $userCompany = new Company();
            $userCompany->setName($userItem['company']);
            $manager->persist($userCompany);

            $user = $this->userFactory->create($userItem['email'], $userItem['password'], $userCompany);
            $user->setRoles(['ROLE_ADMIN']);

            $manager->persist($user);
        }


        $userOwner = $this->userFactory->create('doston@karimov.com', 'dostonKarimov', $company);
        $userOwner->setRoles(['ROLE_ADMIN', 'ROLE_OWNER']);
        $manager->persist($userOwner);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [CompanyFixtures::class];
    }
}
