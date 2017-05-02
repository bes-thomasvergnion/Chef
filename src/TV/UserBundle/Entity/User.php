<?php

namespace TV\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="TV\UserBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\OneToOne(targetEntity="TV\ChefBundle\Entity\Image", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $image;
    
    /**
     * @ORM\ManyToOne(targetEntity="TV\UserBundle\Entity\LevelUser", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $level;
    
    /**
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    protected $content;
    
    /**
     * @ORM\OneToMany(targetEntity="TV\ChefBundle\Entity\Recipe", mappedBy="author", cascade={"remove"})
     */
    private $recipes;
    
    public function __construct()
    {
      $this->recipes = new ArrayCollection();
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
     * Set image
     *
     * @param \TV\ChefBundle\Entity\Image $image
     *
     * @return User
     */
    public function setImage(\TV\ChefBundle\Entity\Image $image = null)
    {
        $this->image = $image;
        return $this;
    }
    /**
     * Get image
     *
     * @return \TV\ChefBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }
    
     /**
     * Set level
     *
     * @param string $level
     *
     * @return User
     */
    public function setLevel($level)
    {
        $this->level = $level;
        return $this;
    }
    
    /**
     * Get level
     *
     * @return string
     */
    public function getLevel()
    {
        return $this->level;
    }
    
    public function setContent($content)
    {
      $this->content = $content;
    }
    
    public function getContent()
    {
      return $this->content;
    }
    
    public function addRecipe(\TV\ChefBundle\Entity\Recipe $recipe)
    {
      $this->recipes[] = $recipe;
      $recipe->setAuthor($this);
      return $this;
    }
    
    public function removeRecipe(\TV\ChefBundle\Entity\Recipe $recipe)
    {
      $this->recipes->removeElement($recipe);
    }
    
    public function getRecipes()
    {
      return $this->recipes;
    }
}

