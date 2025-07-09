<?php

declare(strict_types=1);

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Dto\QuestionOutput;
use App\Dto\SurveyOutput;
use App\Entity\Survey;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

readonly class SurveyProvider implements ProviderInterface
{
    public function __construct(
        private EntityManagerInterface $em,
        private RequestStack $requestStack
    ) {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): SurveyOutput
    {
        $locale = $this->requestStack->getCurrentRequest()?->headers->get('Accept-Languages', 'uz');

        $survey = $this->em->getRepository(Survey::class)->find(1);
        $questions = $survey->getQuestions();

        $newQuestions = [];

        foreach ($questions->toArray() as $question) {
            $newQuestions[] = new QuestionOutput($question->getId(), $question->getText($locale));
        }

        return new SurveyOutput(
            $survey->getId(),
            $survey->getTitle($locale),
            $newQuestions
        );
    }
}
