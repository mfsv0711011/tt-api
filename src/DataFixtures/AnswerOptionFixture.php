<?php

namespace App\DataFixtures;

use App\Entity\AnswerOption;
use App\Entity\Company;
use App\Enum\AnswerValue;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AnswerOptionFixture extends Fixture implements DependentFixtureInterface
{
    private array $answerOptions = [
        [
            'label' => [
                'uz' => 'Ha',
                'ru' => 'Да'
            ],
            'value' => AnswerValue::YES
        ],
        [
            'label' => [
                'uz' => 'Yo\'q',
                'ru' => 'Нет'
            ],
            'value' => AnswerValue::NO
        ]
    ];

    public function load(ObjectManager $manager): void
    {
        $company = $this->getReference(CompanyFixtures::COMPANY, Company::class);

        foreach ($this->answerOptions as $answerOption) {
            $newAnswerOption = new AnswerOption();
            $newAnswerOption->setLabel($answerOption['label']);
            $newAnswerOption->setValue($answerOption['value']);

            $manager->persist($newAnswerOption);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [CompanyFixtures::class];
    }
}
