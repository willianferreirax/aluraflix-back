<?php

namespace App\Models;

use App\Repositories\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ORM\Table(name: 'categories')]
class Category{

    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(type: 'string')]
    private string $title;

    #[ORM\Column(type: 'string')]
    private string $color;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Video::class)]
    private Collection $videos;

    #[ORM\Column(type: 'datetime')]
    private \DateTime $created_at;

    #[ORM\Column(type: 'datetime')]
    private \DateTime $updated_at;

    public function __construct()
    {
        $this->videos = new ArrayCollection();
    }

    public function addVideo(Video $video)
    {
        $this->videos[] = $video;
    }

    /**
     * Get the value of id
     */ 
    public function getId(): int
    {
        return $this->id;
    }


    /**
     * Get the value of title
     */ 
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function setTitle(string $title): self
    {

        $title = trim($title);

        if(!$title){
            throw new \DomainException('Title is required');
        }

        if(is_numeric($title)){
            throw new \DomainException('Title must be a string');
        }

        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of color
     */ 
    public function getColor(): string
    {
        return $this->color;
    }

    /**
     * Set the value of color
     *
     * @return  self
     */ 
    public function setColor(string $color): self
    {

        $color = trim($color);

        if(!$color){
            throw new \DomainException('Color is required');
        }

        if(is_numeric($color)){
            throw new \DomainException('Color must be a string');
        }

        $this->color = $color;

        return $this;
    }

    /**
     * Get the value of created_at
     */ 
    public function getCreatedAt(): string
    {
        return $this->created_at->format('Y-m-d H:i:s');
    }

    /**
     * Set the value of created_at
     *
     * @return  self
     */ 
    public function setCreatedAt(\Datetime $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * Get the value of updated_at
     */ 
    public function getUpdatedAt(): string
    {
        return $this->updated_at->format('Y-m-d H:i:s');
    }

    /**
     * Set the value of updated_at
     *
     * @return  self
     */ 
    public function setUpdatedAt(\Datetime $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

}