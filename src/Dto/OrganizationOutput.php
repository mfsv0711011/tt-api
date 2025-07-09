<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Serializer\Annotation\Groups;

readonly class OrganizationOutput
{
    public function __construct(
        #[Groups(['organization:read'])]
        private int $id,

        #[Groups(['organization:read'])]
        private string $name,

        #[Groups(['organization:read'])]
        private int $negativeCount,

        #[Groups(['organization:read'])]
        private int $positiveCount,
    ) {
    }

    public function getNegativeCount(): int
    {
        return $this->negativeCount;
    }

    public function getPositiveCount(): int
    {
        return $this->positiveCount;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
