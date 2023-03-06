<?php

namespace App\Models;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'users')]
class User {

    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(type: 'string')]
    private string $name;

    #[ORM\Column(type: 'string')]
    private string $login;

    #[ORM\Column(type: 'string')]
    private string $pass;

    #[ORM\Column(type: 'datetime')]
    private \DateTime $created_at;

    #[ORM\Column(type: 'datetime')]
    private \DateTime $updated_at;

    public function __construct(){}

    /**
     * Get the value of id
     */ 
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get the value of name
     */ 
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName(string $name): self
    {

        $name = trim($name);

        if(!$name){
            throw new \DomainException('Name is required');
        }

        if(is_numeric($name)){
            throw new \DomainException('Name must be a string');
        }

        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of login
     */ 
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * Set the value of login
     *
     * @return  self
     */ 
    public function setLogin(string $login): self
    {
        $login = trim($login);

        if(!$login){
            throw new \DomainException('Login is required');
        }

        if(is_numeric($login)){
            throw new \DomainException('Login must be a string');
        }

        $this->login = $login;

        return $this;
    }

    /**
     * Get the value of pass
     */ 
    public function getPass(): string
    {
        return $this->pass;
    }

    /**
     * Set the value of pass
     *
     * @return  self
     */ 
    public function setPass(string $pass): self
    {

        $pass = trim($pass);

        if(!$pass){
            throw new \DomainException('Password is required');
        }

        $this->pass = password_hash($pass, PASSWORD_DEFAULT);

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