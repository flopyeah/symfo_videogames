<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ConsoleRepository")
 */
class Console
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $marque;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\JeuVideo", mappedBy="console")
     */
    private $jeuVideos;

    public function __construct()
    {
        $this->jeuVideos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection|JeuVideo[]
     */
    public function getJeuVideos(): Collection
    {
        return $this->jeuVideos;
    }

    public function addJeuVideo(JeuVideo $jeuVideo): self
    {
        if (!$this->jeuVideos->contains($jeuVideo)) {
            $this->jeuVideos[] = $jeuVideo;
            $jeuVideo->addConsole($this);
        }

        return $this;
    }

    public function removeJeuVideo(JeuVideo $jeuVideo): self
    {
        if ($this->jeuVideos->contains($jeuVideo)) {
            $this->jeuVideos->removeElement($jeuVideo);
            $jeuVideo->removeConsole($this);
        }

        return $this;
    }
}
