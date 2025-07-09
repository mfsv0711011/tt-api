<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Dto\SurveyOutput;
use App\Repository\SurveyRepository;
use App\State\SurveyProvider;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SurveyRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(
            output: SurveyOutput::class,
            provider: SurveyProvider::class
        ),
    ],
    normalizationContext: ['groups' => ['survey:read']],
    denormalizationContext: ['groups' => ['survey:write']]
)]
class Survey
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['survey:read', 'survey:write', 'submission:read'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['survey:read', 'survey:write', 'submission:read'])]
    private ?array $title = null;

    /**
     * @var Collection<int, Question>
     */
    #[ORM\ManyToMany(targetEntity: Question::class, inversedBy: 'surveys')]
    #[Groups(['survey:read', 'survey:write'])]
    private Collection $questions;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle($location = 'uz'): ?string
    {
        return $this->title[$location] ?? null;
    }

    public function setTitle(array $title): static
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection<int, Question>
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Question $question): static
    {
        if (!$this->questions->contains($question)) {
            $this->questions->add($question);
        }

        return $this;
    }

    public function removeQuestion(Question $question): static
    {
        $this->questions->removeElement($question);

        return $this;
    }
}
