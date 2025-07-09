<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Serializer\Annotation\Groups;

readonly class QuestionOutput
{
    public function __construct(
        #[Groups(['survey:read'])]
        private int $id,

        #[Groups(['survey:read'])]
        private string $text,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getText(): string
    {
        return $this->text;
    }
}
