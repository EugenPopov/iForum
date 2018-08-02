<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TopicsRepository")
 */
class Topics
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Sections", inversedBy="topics")
     * @ORM\JoinColumn(nullable=true)
     */
    private $section;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="boolean")
     */
    private $close;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Users", inversedBy="topics")
     * @ORM\JoinColumn(nullable=true)
     */
    private $author;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Messages", inversedBy="topics")
     * @ORM\JoinColumn(nullable=true)
     */
    private $last_message;

    /**
     * @return mixed
     */
    public function getLastMessage(): ?Messages
    {
        return $this->last_message;
    }

    /**
     * @param mixed $last_message
     */
    public function setLastMessage(Messages $last_message): void
    {
        $this->last_message = $last_message;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getSection()
    {
        return $this->section;
    }

    public function setSection(Sections $sections)
    {
        $this->section = $sections;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getClose(): ?bool
    {
        return $this->close;
    }

    public function setClose(bool $close): self
    {
        $this->close = $close;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

}