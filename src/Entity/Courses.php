<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CoursesRepository")
 */
class Courses
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\Column(type="date")
     */
    private $date_create;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="courses")
     */
    private $contributor;

    /**
     * @ORM\Column(type="integer")
     */
    private $number_view;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categories", inversedBy="courses")
     */
    private $categories;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="course")
     */
    private $user;

    public function __construct()
    {
        $this->contributor = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getDateCreate(): ?\DateTimeInterface
    {
        return $this->date_create;
    }

    public function setDateCreate(\DateTimeInterface $date_create): self
    {
        $this->date_create = $date_create;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|user[]
     */
    public function getContributor(): Collection
    {
        return $this->contributor;
    }

    public function addContributor(user $contributor): self
    {
        if (!$this->contributor->contains($contributor)) {
            $this->contributor[] = $contributor;
        }

        return $this;
    }

    public function removeContributor(user $contributor): self
    {
        if ($this->contributor->contains($contributor)) {
            $this->contributor->removeElement($contributor);
        }

        return $this;
    }

    public function getNumberView(): ?int
    {
        return $this->number_view;
    }

    public function setNumberView(int $number_view): self
    {
        $this->number_view = $number_view;

        return $this;
    }

    public function getCategories(): ?Categories
    {
        return $this->categories;
    }

    public function setCategories(?Categories $categories): self
    {
        $this->categories = $categories;

        return $this;
    }

    public function __ToString(){
        return $this->name;
    }

    /**
     * @return Collection|User[]
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user[] = $user;
            $user->addCourse($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->user->contains($user)) {
            $this->user->removeElement($user);
            $user->removeCourse($this);
        }

        return $this;
    }
}
