<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

readonly class UserCreateDto
{
    public function __construct(
        #[Groups(['user:read', 'user:write'])]
        #[Assert\Email]
        private string $email,

        #[Groups(['user:read', 'user:write'])]
        #[Assert\Length(min: 6, minMessage: 'Password must be at least {{ limit }} characters long')]
        private string $password,

        #[Groups(['user:read', 'user:write'])]
        #[Assert\NotBlank]
        private string $companyName,
    ) {
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getCompanyName(): string
    {
        return $this->companyName;
    }
}
