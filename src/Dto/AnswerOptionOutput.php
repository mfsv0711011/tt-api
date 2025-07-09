<?php

declare(strict_types=1);

namespace App\Dto;

use App\Enum\AnswerValue;

readonly class AnswerOptionOutput
{
    public function __construct(
        private int $id,
        private string $label,
        private AnswerValue $value,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getValue(): AnswerValue
    {
        return $this->value;
    }
}
