<?php

declare(strict_types=1);

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Dto\OrganizationOutput;
use App\Dto\QuestionOutput;
use App\Entity\Organization;
use App\Entity\Question;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

readonly class QuestionProvider implements ProviderInterface
{
    public function __construct(
        private EntityManagerInterface $em,
        private RequestStack $requestStack
    ) {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array
    {
        $locale = $this->requestStack->getCurrentRequest()?->headers->get('Accept-Languages', 'uz');

        $questions = $this->em->getRepository(Question::class)->findAll();

        $result = [];

        foreach ($questions as $question) {
            $result[] = new QuestionOutput($question->getId(), $question->getText($locale));
        }

        return $result;
    }
}
