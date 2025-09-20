<?php

namespace App\DataFixtures;

use App\Entity\Company;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CompanyFixtures extends Fixture
{
    public const COMPANY = 'common_company';

    public function load(ObjectManager $manager): void
    {
         $company = new Company();

         $company->setName('COMMON_COMPANY');

         $manager->persist($company);

         $manager->flush();

         $this->addReference(self::COMPANY, $company);
    }
}
