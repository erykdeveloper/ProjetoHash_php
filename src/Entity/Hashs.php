<?php

namespace App\Entity;

use App\Repository\HashsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HashsRepository::class)]
class Hashs
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $batch;

    #[ORM\Column(type: 'integer')]
    private ?int $nblock;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $string;

    #[ORM\Column(type: 'string', length: 32)]
    private ?string $generatedkey;

    #[ORM\Column(type: 'string', length: 32)]
    private ?string $generatedhash;

    #[ORM\Column(type: 'integer')]
    private ?int $attemps;

    #[ORM\Column(type: 'string', length: 8)]
    private ?string $hashIdentifier;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function gethashIdentifier(): ?string
    {
        return $this->hashIdentifier;
    }

    public function sethashIdentifier(string $hashIdentifier): self
    {
        $this->hashIdentifier = $hashIdentifier;

        return $this;
    }

    public function getBatch(): ?\DateTimeInterface
    {
        return $this->batch;
    }

    public function setBatch(\DateTimeInterface $batch): self
    {
        $this->batch = $batch;

        return $this;
    }

    public function getNblock(): ?int
    {
        return $this->nblock;
    }

    public function setNblock(int $nblock): self
    {
        $this->nblock = $nblock;

        return $this;
    }

    public function getString(): ?string
    {
        return $this->string;
    }

    public function setString(string $string): self
    {
        $this->string = $string;

        return $this;
    }

    public function getGeneratedkey(): ?string
    {
        return $this->generatedkey;
    }

    public function setGeneratedkey(string $generatedkey): self
    {
        $this->generatedkey = $generatedkey;

        return $this;
    }

    public function getGeneratedhash(): ?string
    {
        return $this->generatedhash;
    }

    public function setGeneratedhash(string $generatedhash): self
    {
        $this->generatedhash = $generatedhash;

        return $this;
    }

    public function getAttemps(): ?int
    {
        return $this->attemps;
    }

    public function setAttemps(int $attemps): self
    {
        $this->attemps = $attemps;

        return $this;
    }
}
