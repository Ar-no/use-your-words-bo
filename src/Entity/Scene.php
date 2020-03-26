<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SceneRepository")
 */
class Scene
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
    private $url;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UsedScene", mappedBy="scene", orphanRemoval=true)
     */
    private $usedScenes;

    public function __construct()
    {
        $this->usedScenes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

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
            $usedScene->setScene($this);
        }

        return $this;
    }

    public function removeUsedScene(UsedScene $usedScene): self
    {
        if ($this->usedScenes->contains($usedScene)) {
            $this->usedScenes->removeElement($usedScene);
            // set the owning side to null (unless already changed)
            if ($usedScene->getScene() === $this) {
                $usedScene->setScene(null);
            }
        }

        return $this;
    }
}
