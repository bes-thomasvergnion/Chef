<?php

namespace TV\ChefBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Liste
 *
 * @ORM\Table(name="liste")
 * @ORM\Entity(repositoryClass="TV\ChefBundle\Repository\ListeRepository")
 */
class Liste
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\OneToOne(targetEntity="TV\UserBundle\Entity\User", inversedBy="liste", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;
    
    /**
     * @ORM\OneToMany(targetEntity="TV\ChefBundle\Entity\Ingredient", mappedBy="liste", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $ingredients;
    
    
    public function __construct()
    {
        $this->ingredients = new ArrayCollection();
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Set user
     *
     * @param \TV\UserBundle\Entity\User $user
     *
     * @return Notebook
     */
    public function setUser(\TV\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;
        
        return $this;
    }

    /**
     * Get user
     *
     * @return \TV\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
    
    public function addIngredient(Ingredient $ingredient)
    {
        $this->ingredients[] = $ingredient;
        
        $ingredient->setListe($this);
        return($this);
    }

    public function removeIngredient(Ingredient $ingredient)
    {
        $this->ingredients->removeElement($ingredient);
    }

    public function getIngredients()
    {
        return $this->ingredients;
    }
}

