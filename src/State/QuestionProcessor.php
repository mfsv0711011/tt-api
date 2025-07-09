<?php

declare(strict_types=1);

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Dto\OrganizationInput;
use App\Dto\QuestionInput;
use App\Entity\Organization;
use App\Entity\Question;
use Doctrine\ORM\EntityManagerInterface;

readonly class QuestionProcessor implements ProcessorInterface
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): Question
    {
        if (!$data instanceof QuestionInput) {
            throw new \InvalidArgumentException('Invalid data.');
        }

        $question = new Question();
        $question->setText($data->getText()->toArray());

        $this->em->persist($question);
        $this->em->flush();

        return $question;
    }
}
