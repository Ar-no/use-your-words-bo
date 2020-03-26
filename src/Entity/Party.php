<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PartyRepository")
 */
class Party
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $accessCode;

    /**
     * @ORM\Column(type="integer")
     */
    private $currentStep;

    /**
     * @ORM\Column(type="date")
     */
    private $creationDate;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Player", mappedBy="party", orphanRemoval=true)
     */
    private $players;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UsedScene", mappedBy="party", orphanRemoval=true)
     */
    private $usedScenes;

    public function __construct()
    {
        $this->players = new ArrayCollection();
        $this->usedScenes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAccessCode(): ?string
    {
        return $this->accessCode;
    }

    public function setAccessCode(string $accessCode): self
    {
        $this->accessCode = $accessCode;

        return $this;
    }

    public function getCurrentStep(): ?int
    {
        return $this->currentStep;
    }

    public function setCurrentStep(int $currentStep): self
    {
        $this->currentStep = $currentStep;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeInterface $creationDate): self
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * @return Collection|Player[]
     */
    public function getPlayers(): Collection
    {
        return $this->players;
    }

    public function addPlayer(Player $player): self
    {
        if (!$this->players->contains($player)) {
            $this->players[] = $player;
            $player->setParty($this);
        }

        return $this;
    }

    public function removePlayer(Player $player): self
    {
        if ($this->players->contains($player)) {
            $this->players->removeElement($player);
            // set the owning side to null (unless already changed)
            if ($player->getParty() === $this) {
                $player->setParty(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|UsedScene[]
     */
    public function getUsedScenes(): Collection
    {
        return $this->usedScenes;
    }

    public function addUsedScene(UsedScene $usedScene): self
    {
        if (!$this->usedScenes->contains($usedScene)) {
            $this->usedScenes[] = $usedScene;
            $usedScene->setParty($this);
        }

        return $this;
    }

    public function removeUsedScene(UsedScene $usedScene): self
    {
        if ($this->usedScenes->contains($usedScene)) {
            $this->usedScenes->removeElement($usedScene);
            // set the owning side to null (unless already changed)
            if ($usedScene->getParty() === $this) {
                $usedScene->setParty(null);
            }
        }

        return $this;
    }
}
