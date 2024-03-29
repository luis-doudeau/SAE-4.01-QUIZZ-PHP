<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]

     /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Question name is required")
     * @Assert\Type(type="string", message="Question name should be a string")
     */
    private ?string $nomQuestion = null;

    #[ORM\OneToMany(mappedBy: 'question', targetEntity: Reponse::class)]
    private Collection $reponses;

    #[ORM\ManyToOne(inversedBy: 'questions')]
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Questionnaire", inversedBy="questions")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Questionnaire $questionnaire = null;

    #[ORM\Column]
     /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Points for question is required")
     * @Assert\Type(type="integer", message="Points for question should be an integer")
     * @Assert\GreaterThan(value=0, message="Points for question should be greater than zero")
     */
    private ?int $pointQuestion = null;

    #[ORM\Column(length: 255)]
    private ?string $typeQuestion = null;

    public function __construct()
    {
        $this->reponses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomQuestion(): ?string
    {
        return $this->nomQuestion;
    }

    public function setNomQuestion(string $nomQuestion): self
    {
        $this->nomQuestion = $nomQuestion;

        return $this;
    }

    /**
     * @return Collection<int, Reponse>
     */
    public function getReponses(): Collection
    {
        return $this->reponses;
    }

    public function addReponse(Reponse $reponse): self
    {
        if (!$this->reponses->contains($reponse)) {
            $this->reponses->add($reponse);
            $reponse->setQuestion($this);
        }

        return $this;
    }

    public function removeReponse(Reponse $reponse): self
    {
        if ($this->reponses->removeElement($reponse)) {
            // set the owning side to null (unless already changed)
            if ($reponse->getQuestion() === $this) {
                $reponse->setQuestion(null);
            }
        }

        return $this;
    }

    public function getQuestionnaire(): ?Questionnaire
    {
        return $this->questionnaire;
    }

    public function setQuestionnaire(?Questionnaire $questionnaire): self
    {
        $this->questionnaire = $questionnaire;

        return $this;
    }

    public function getPointQuestion(): ?int
    {
        return $this->pointQuestion;
    }

    public function setPointQuestion(int $pointQuestion): self
    {
        $this->pointQuestion = $pointQuestion;

        return $this;
    }

    public function __toString()
{
    return $this->nomQuestion;
}

    public function getTypeQuestion(): ?string
    {
        return $this->typeQuestion;
    }

    public function setTypeQuestion(string $typeQuestion): self
    {
        $this->typeQuestion = $typeQuestion;

        return $this;
    }
}
