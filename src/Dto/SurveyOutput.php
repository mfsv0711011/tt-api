<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Serializer\Annotation\Groups;

readonly class SurveyOutput
{
    public function __construct(
        #[Groups(['survey:read'])]
        private int $id,

        #[Groups(['survey:read'])]
        private string $title,

        #[Groups(['survey:read'])]
        private array $questions,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getQuestions(): array
    {
        return $this->questions;
    }
}
