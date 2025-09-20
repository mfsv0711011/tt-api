<?php

declare(strict_types=1);

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Submission;
use App\Enum\AnswerValue;

readonly class SubmissionProcessor implements ProcessorInterface
{
    public function __construct(private ProcessorInterface $processor)
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
            $value = $answer->getAnswerOption()->getValue();
            $questionId = $answer->getQuestion()->getId();

            $isNegative = ($questionId === 2 && $value === AnswerValue::YES) ||
                ($questionId !== 2 && $value === AnswerValue::NO);

            $isNegative ? $negativeCount++ : $positiveCount++;
        }

        $data->getOrganization()->setPositiveCount($data->getOrganization()->getPositiveCount() + $positiveCount);
        $data->getOrganization()->setNegativeCount($data->getOrganization()->getNegativeCount() + $negativeCount);

        return $this->processor->process($data, $operation, $uriVariables, $context);
    }
}
