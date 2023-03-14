<?php

namespace App\Models;

use App\Repositories\VideoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VideoRepository::class)]
#[ORM\Table(name: 'videos')]
class Video{

    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(type: 'string')]
    private string $title;

    #[ORM\Column(type: 'string')]
    private string $url;

    #[ORM\Column(type: 'string')]
    private string $description;

    #[ORM\OneToOne(targetEntity: Category::class)]
    private Category $category;

    #[ORM\Column(type: 'datetime')]
    private \DateTime $created_at;

    #[ORM\Column(type: 'datetime')]
    private \DateTime $updated_at;

    /**
     * Get the value of id
     */ 
    public function getId(): string
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
     * Get the value of url
     */ 
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * Set the value of url
     *
     * @return  self
     */ 
    public function setUrl(string $url): self
    {

        if(!filter_var($url, FILTER_VALIDATE_URL)){
            throw new \DomainException('Invalid URL, make sure to include http:// or https://');
        }

        $this->url = $url;

        return $this;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription(string $description): self
    {

        $description = trim($description);

        if(!$description){
            throw new \DomainException('Description is required');
        }

        if(is_numeric($description)){
            throw new \DomainException('Description must be a string');
        }

        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of category
     */ 
    public function getCategory(): int
    {
        return $this->category->getId();
    }

    /**
     * Set the value of category
     *
     * @return  self
     */ 
    public function setCategory(Category $category): self
    {

        $category->addVideo($this);
        $this->category = $category;

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
    public function setCreatedAt(\DateTime $created_at): self
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
    public function setUpdatedAt(\DateTime $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    // public function jsonSerialize()
    // {
    //     $vars = get_object_vars($this);

    //     //datetime objects must return only the date
    //     foreach($vars as $key => $value){
    //         if($value instanceof \DateTime){
    //             $vars[$key] = $value->format('Y-m-d H:i:s');
    //         }
    //     }

    //     return $vars;
    // }
}