<?php

declare(strict_types=1);

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Submission;
use App\Enum\AnswerValue;
use Doctrine\ORM\EntityManagerInterface;

readonly class SubmissionProcessor implements ProcessorInterface
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): Submission
    {
        if (!$data instanceof Submission) {
            throw new \InvalidArgumentException('Invalid data.');
        }

        $positiveCount = 0;
        $negativeCount = 0;

        foreach ($data->getAnswers() as $answer) {
            if ($answer->getAnswerOption()->getValue() === AnswerValue::YES) {
                $positiveCount++;
            } else {
                $negativeCount++;
            }
        }

        $data->getOrganization()->setPositiveCount($data->getOrganization()->getPositiveCount() + $positiveCount);
        $data->getOrganization()->setNegativeCount($data->getOrganization()->getNegativeCount() + $negativeCount);
        $this->em->persist($data);
        $this->em->persist($data->getOrganization());
        $this->em->flush();

        return $data;
    }
}
