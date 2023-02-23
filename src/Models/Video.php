<?php

namespace App\Models;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
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

    #[ORM\Column(type: 'datetime')]
    private \DateTime $created_at;

    #[ORM\Column(type: 'datetime')]
    private \DateTime $updated_at;

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of title
     */ 
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function setTitle($title)
    {

        if(!trim($title)){
            throw new \DomainException('Title is required');
        }

        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of url
     */ 
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set the value of url
     *
     * @return  self
     */ 
    public function setUrl($url)
    {

        if(!filter_var($url, FILTER_VALIDATE_URL)){
            throw new \DomainException('Invalid URL');
        }

        $this->url = $url;

        return $this;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription($description)
    {

        if(!trim($description)){
            throw new \DomainException('Description is required');
        }

        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of created_at
     */ 
    public function getCreatedAt()
    {
        return $this->created_at->format('Y-m-d H:i:s');
    }

    /**
     * Set the value of created_at
     *
     * @return  self
     */ 
    public function setCreatedAt(\DateTime $created_at)
    {

        $this->created_at = $created_at;

        return $this;
    }

    /**
     * Get the value of updated_at
     */ 
    public function getUpdatedAt()
    {
        return $this->updated_at->format('Y-m-d H:i:s');
    }

    /**
     * Set the value of updated_at
     *
     * @return  self
     */ 
    public function setUpdatedAt(\DateTime $updated_at)
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