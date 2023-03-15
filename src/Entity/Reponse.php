<?php

namespace App\Entity;

use App\Repository\ReponseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReponseRepository::class)]
class Reponse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomReponse = null;

    #[ORM\ManyToOne(inversedBy: 'reponses')]
    private ?Question $question = null;

    private $estCorrect;

    public function getId(): ?int
    {
        return $this->id;
    }

     public function getEstCorrect(): ?bool
    {
        return $this->estCorrect;
    }

    public function setEstCorrect(bool $estCorrect): self
    {
        $this->estCorrect = $estCorrect;

        return $this;
    }

    public function getNomReponse(): ?string
    {
        return $this->nomReponse;
    }

    public function setNomReponse(string $nomReponse): self
    {
        $this->nomReponse = $nomReponse;

        return $this;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): self
    {
        $this->question = $question;

        return $this;
    }
}
