<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Dto\QuestionOutput;
use App\Repository\QuestionRepository;
use App\State\QuestionProvider;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(
            output: QuestionOutput::class,
            provider: QuestionProvider::class,
        ),
//        new Post(
//            input: QuestionInput::class,
//            processor: QuestionProcessor::class
//        )
    ]
)]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['survey:read', 'submission:read'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['survey:read', 'submission:read'])]
    private array $text = [];

    /**
     * @var Collection<int, Survey>
     */
    #[ORM\ManyToMany(targetEntity: Survey::class, mappedBy: 'questions')]
    private Collection $surveys;

    public function __construct()
    {
        $this->surveys = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(string $locale = 'uz'): ?string
    {
        return $this->text[$locale] ?? null;
    }

    public function setText(array $text): static
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return Collection<int, Survey>
     */
    public function getSurveys(): Collection
    {
        return $this->surveys;
    }

    public function addSurvey(Survey $survey): static
    {
        if (!$this->surveys->contains($survey)) {
            $this->surveys->add($survey);
            $survey->addQuestion($this);
        }

        return $this;
    }

    public function removeSurvey(Survey $survey): static
    {
        if ($this->surveys->removeElement($survey)) {
            $survey->removeQuestion($this);
        }

        return $this;
    }
}
