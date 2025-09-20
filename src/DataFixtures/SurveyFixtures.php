<?php

namespace App\DataFixtures;

use App\Entity\Company;
use App\Entity\Question;
use App\Entity\Survey;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SurveyFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $questions = $manager->getRepository(Question::class)->findAll();
        $company = $this->getReference(CompanyFixtures::COMPANY, Company::class);

        $newSurvey = new Survey();
        $newSurvey->setTitle(['uz' => 'So\'rovnoma', 'ru' => 'Опрос']);

        /** @var Question $question */
        foreach ($questions as $question) {
            $newSurvey->addQuestion($question);
        }

        $manager->persist($newSurvey);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [CompanyFixtures::class, QuestionFixtures::class];
    }
}
