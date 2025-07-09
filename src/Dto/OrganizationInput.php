<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\MediaObject;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

readonly class OrganizationInput
{
    public function __construct(
        #[Assert\Valid]
        #[Groups(['organization:write'])]
        private Translation $name,

        #[Groups(['organization:write'])]
        private ?MediaObject $logo,
    ) {
    }

    public function getLogo(): ?MediaObject
    {
        return $this->logo;
    }

    public function getName(): Translation
    {
        return $this->name;
    }
}
