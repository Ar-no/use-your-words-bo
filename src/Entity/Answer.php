<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AnswerRepository")
 */
class Answer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\UsedScene", inversedBy="answers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $usedScene;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Player", inversedBy="answers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $player;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $answer;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Vote", mappedBy="answer", orphanRemoval=true)
     */
    private $votes;

    public function __construct()
    {
        $this->votes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsedScene(): ?UsedScene
    {
        return $this->usedScene;
    }

    public function setUsedScene(?UsedScene $usedScene): self
    {
        $this->usedScene = $usedScene;

        return $this;
    }

    public function getPlayer(): ?Player
    {
        return $this->player;
    }

    public function setPlayer(?Player $player): self
    {
        $this->player = $player;

        return $this;
    }

    public function getAnswer(): ?string
    {
        return $this->answer;
    }

    public function setAnswer(?string $answer): self
    {
        $this->answer = $answer;

        return $this;
    }

    /**
     * @return Collection|Vote[]
     */
    public function getVotes(): Collection
    {
        return $this->votes;
    }

    public function addVote(Vote $vote): self
    {
        if (!$this->votes->contains($vote)) {
            $this->votes[] = $vote;
            $vote->setAnswer($this);
        }

        return $this;
    }

    public function removeVote(Vote $vote): self
    {
        if ($this->votes->contains($vote)) {
            $this->votes->removeElement($vote);
            // set the owning side to null (unless already changed)
            if ($vote->getAnswer() === $this) {
                $vote->setAnswer(null);
            }
        }

        return $this;
    }
}
