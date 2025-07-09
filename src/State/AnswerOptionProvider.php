<?php

declare(strict_types=1);

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Dto\AnswerOptionOutput;
use App\Dto\OrganizationOutput;
use App\Entity\AnswerOption;
use App\Entity\Organization;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

readonly class AnswerOptionProvider implements ProviderInterface
{
    public function __construct(
        private EntityManagerInterface $em,
        private RequestStack $requestStack
    ) {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array
    {
        $locale = $this->requestStack->getCurrentRequest()?->headers->get('Accept-Languages', 'uz');

        $answerOptions = $this->em->getRepository(AnswerOption::class)->findAll();

        $result = [];

        foreach ($answerOptions as $answerOption) {
            $result[] = new AnswerOptionOutput($answerOption->getId(), $answerOption->getLabel($locale), $answerOption->getValue());
        }

        return $result;
    }
}
