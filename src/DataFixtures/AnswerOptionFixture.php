<?php

namespace App\DataFixtures;

use App\Entity\AnswerOption;
use App\Enum\AnswerValue;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AnswerOptionFixture extends Fixture
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
        foreach ($this->answerOptions as $answerOption) {
            $newAnswerOption = new AnswerOption();
            $newAnswerOption->setLabel($answerOption['label']);
            $newAnswerOption->setValue($answerOption['value']);

            $manager->persist($newAnswerOption);
        }

        $manager->flush();
    }
}
