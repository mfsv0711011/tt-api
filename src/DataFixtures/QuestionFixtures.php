<?php

namespace App\DataFixtures;

use App\Entity\Company;
use App\Entity\Question;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class QuestionFixtures extends Fixture implements DependentFixtureInterface
{
    private array $questions = [
        [
            'uz' => 'Davlat xizmati sifati sizni qanoatlantiradimi?',
            'ru' => 'Вас устраивает качество государственной услуги?'
        ],
        [
            'uz' => 'Korrupsiyaga duch keldingizmi?',
            'ru' => 'Вы сталкивались с коррупцией?'
        ],
        [
            'uz' => 'Bu yerda shaffoflik bormi?',
            'ru' => 'Присутствует ли здесь прозрачность?'
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        $company = $this->getReference(CompanyFixtures::COMPANY, Company::class);

        foreach ($this->questions as $question) {
            $newQuestion = new Question();
            $newQuestion->setText($question);

            $manager->persist($newQuestion);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [CompanyFixtures::class];
    }
}
