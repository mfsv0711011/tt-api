<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Serializer\Annotation\Groups;

readonly class Translation
{
    public function __construct(
        #[Groups(['organization:write'])]
        private string $uz,

        #[Groups(['organization:write'])]
        private string $ru
    ) {
    }

    public function getUz(): string
    {
        return $this->uz;
    }

    public function getRu(): string
    {
        return $this->ru;
    }

    public function toArray(): array
    {
        return [
            'uz' => $this->uz,
            'ru' => $this->ru,
        ];
    }
}
