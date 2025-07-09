<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Dto\AnswerOptionOutput;
use App\Enum\AnswerValue;
use App\Repository\AnswerOptionRepository;
use App\State\AnswerOptionProvider;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: AnswerOptionRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(
            output: AnswerOptionOutput::class,
            provider: AnswerOptionProvider::class
        ),
        new Get(),
    ]
)]
class AnswerOption
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['submission:read'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['submission:read'])]
    private array $label = [];

    #[ORM\Column(length: 255, enumType: AnswerValue::class)]
    #[Groups(['submission:read'])]
    private ?AnswerValue $value = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel($locale = 'uz'): ?string
    {
        return $this->label[$locale] ?? null;
    }

    public function setLabel(array $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getValue(): ?AnswerValue
    {
        return $this->value;
    }

    public function setValue(AnswerValue $value): static
    {
        $this->value = $value;

        return $this;
    }
}
