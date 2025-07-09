<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Dto\OrganizationInput;
use App\Dto\OrganizationOutput;
use App\Repository\OrganizationRepository;
use App\State\OrganizationProcessor;
use App\State\OrganizationProvider;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: OrganizationRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(
            paginationClientEnabled: true,
            output: OrganizationOutput::class,
            provider: OrganizationProvider::class
        ),
        new Post(
            security: 'is_granted("ROLE_ADMIN")',
            input: OrganizationInput::class,
            processor: OrganizationProcessor::class
        ),
        new Get(),
        new Patch(
            security: 'is_granted("ROLE_ADMIN")',
        ),
        new Delete(
            security: 'is_granted("ROLE_ADMIN")',
        ),
    ],
    normalizationContext: ['groups' => ['organization:read']],
    denormalizationContext: ['groups' => ['organization:write']]
)]
class Organization
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['organization:read', 'submission:read'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['organization:read', 'organization:write', 'submission:read'])]
    private array $name = [];

    #[ORM\ManyToOne]
    #[Groups(['organization:read', 'organization:write', 'submission:read'])]
    private ?MediaObject $logo = null;

    #[ORM\Column]
    #[Groups(['organization:read'])]
    private ?int $negativeCount = 0;

    #[ORM\Column]
    #[Groups(['organization:read'])]
    private ?int $positiveCount = 0;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?array
    {
        return $this->name;
    }

    public function getTranslatedName(string $locale = 'uz'): ?string
    {
        return $this->name[$locale] ?? null;
    }

    public function setName(array $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getLogo(): ?MediaObject
    {
        return $this->logo;
    }

    public function setLogo(?MediaObject $logo): static
    {
        $this->logo = $logo;

        return $this;
    }

    public function getNegativeCount(): ?int
    {
        return $this->negativeCount;
    }

    public function setNegativeCount(int $negativeCount): static
    {
        $this->negativeCount = $negativeCount;

        return $this;
    }

    public function getPositiveCount(): ?int
    {
        return $this->positiveCount;
    }

    public function setPositiveCount(int $positiveCount): static
    {
        $this->positiveCount = $positiveCount;

        return $this;
    }
}
