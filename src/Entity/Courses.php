<?php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;


/**
 * @ORM\Entity(repositoryClass="App\Repository\CoursesRepository")
 * @Vich\Uploadable
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
     *
     * @ORM\Column(type="string", length=255)
     *
     * @var string|null
     */
    private $fileName;


    /**
     *@var File|null
     * @Vich\UploadableField(mapping="cour_image", fileNameProperty="fileName")
     * 
     * 
     */
    private $image;

    


    /**
     * @ORM\Column(type="datetime")
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
    private $number_view = 0;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categories", inversedBy="courses")
     */
    private $categories;

    
    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="courses_user")
     */
    private $users;

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

    public function getImage(): ?File
    {
        return $this->image;
    }
    /** 
     * @param null|File $image
     * 
     */
    public function setImage(?File $image = null):Courses 
    {
        $this->image = $image;

        
        if ($this->image instanceof UploadedFile ) {
            $this->date_create = new  \DateTime('now');
        }
        return $this;
    }
    
    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(string $fileName): self
    {
        $this->fileName = $fileName;

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
    public function getUsers(): Collection
    {
        return $this->users;
    }
    
    public function addUsers(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addCourse($this);
        }

        return $this;
    }

    public function removeUsers(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            $user->removeCourse($this);
        }

        return $this;
    }
}
