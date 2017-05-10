<?php

namespace TV\ChefBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Notebook
 *
 * @ORM\Table(name="notebook")
 * @ORM\Entity(repositoryClass="TV\ChefBundle\Repository\NotebookRepository")
 */
class Notebook
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
     * @ORM\ManyToMany(targetEntity="TV\ChefBundle\Entity\Recipe", inversedBy="notebooks", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $recipes;
    
    /**
     * @ORM\OneToOne(targetEntity="TV\UserBundle\Entity\User", inversedBy="notebook", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->recipes = new \Doctrine\Common\Collections\ArrayCollection();
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
    
    public function addRecipe(Recipe $recipe)
    {
        $this->recipes[] = $recipe;
        $recipe->addNotebook($this);
        return $this;
    }

    public function removeRecipe(Recipe $recipe)
    {
        $this->recipes->removeElement($recipe);
    }

    public function getRecipes()
    {
        return $this->recipes;
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
}
