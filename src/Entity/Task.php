<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TaskRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
class Task
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetime')]
    private $createdAt;

    #[ORM\Column(type: 'string', length: 64)]
    #[Assert\NotBlank(
        message: 'Vous devez saisir un titre.'
    )]
    #[Assert\Length(
        min: 3,
        max: 64,
        minMessage: 'Le titre doit contenir minimum {{ limit }} caractères',
        maxMessage: 'Le titre doit contenir maximum {{ limit }} caractères'
    )]
    private $title;

    #[ORM\Column(type: 'text')]
    #[Assert\NotBlank(
        message: 'Vous devez saisir du contenu.'
    )]
    private $content;

    #[ORM\Column(type: 'boolean')]
    private $isDone;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'tasks')]
    private $author;

    public function __construct()
    {
        $this->createdAt = new \Datetime();
        $this->isDone = false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function isDone(): ?bool
    {
        return $this->isDone;
    }

    public function toggle($flag): self
    {
        $this->isDone = $flag;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getAuthorUsername(): string
    {
        return $this->getAuthor() !== null ? $this->getAuthor()->getUserIdentifier() : 'Anonyme';
    }
}
