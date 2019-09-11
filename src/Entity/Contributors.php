<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContributorsRepository")
 */
class Contributors
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\user", cascade={"persist", "remove"})
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\courses", mappedBy="contributors")
     */
    private $course_create;

    public function __construct()
    {
        $this->course_create = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|courses[]
     */
    public function getCourseCreate(): Collection
    {
        return $this->course_create;
    }

    public function addCourseCreate(courses $courseCreate): self
    {
        if (!$this->course_create->contains($courseCreate)) {
            $this->course_create[] = $courseCreate;
            $courseCreate->setContributors($this);
        }

        return $this;
    }

    public function removeCourseCreate(courses $courseCreate): self
    {
        if ($this->course_create->contains($courseCreate)) {
            $this->course_create->removeElement($courseCreate);
            // set the owning side to null (unless already changed)
            if ($courseCreate->getContributors() === $this) {
                $courseCreate->setContributors(null);
            }
        }

        return $this;
    }
}
