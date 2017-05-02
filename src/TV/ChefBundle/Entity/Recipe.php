<?php

namespace TV\ChefBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Recipe
 *
 * @ORM\Table(name="recipe")
 * @ORM\Entity(repositoryClass="TV\ChefBundle\Repository\RecipeRepository")
 */
class Recipe
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;
    
    /**
     * @ORM\ManyToOne(targetEntity="TV\UserBundle\Entity\User", inversedBy="recipes", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $author;

    /**
     * @ORM\ManyToOne(targetEntity="TV\ChefBundle\Entity\Level", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $level;
    
    /**
     * @var int
     *
     * @ORM\Column(name="note", type="integer", nullable=true)
     */
    private $note;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_of_pers", type="integer")
     */
    private $nbOfPers;

    /**
     * @var int
     *
     * @ORM\Column(name="cooking_time", type="integer")
     */
    private $cookingTime;

    /**
     * @var int
     *
     * @ORM\Column(name="preparation_time", type="integer")
     */
    private $preparationTime;

    /**
     * @var int
     *
     * @ORM\Column(name="timeout", type="integer")
     */
    private $timeout;
    
    /**
     * @ORM\OneToOne(targetEntity="TV\ChefBundle\Entity\Image", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $image;
    
    /**
     * @ORM\OneToMany(targetEntity="TV\ChefBundle\Entity\Ingredient", mappedBy="recipe", cascade={"persist"}, cascade={"remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $ingredients;
    
    /**
     * @ORM\OneToMany(targetEntity="TV\ChefBundle\Entity\Step", mappedBy="recipe", cascade={"persist"}, cascade={"remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $steps;
    
    /**
     * @ORM\ManyToMany(targetEntity="TV\ChefBundle\Entity\Type", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $types;
    
    /**
     * @ORM\ManyToMany(targetEntity="TV\ChefBundle\Entity\Category", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $categories;
    
    /**
     * @ORM\ManyToMany(targetEntity="TV\ChefBundle\Entity\Locality", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $localities;
    
    public function __construct()
    {
        $this->date = new \Datetime();
        $this->steps = new ArrayCollection();
        $this->ingredients = new ArrayCollection();
        $this->types = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->localities = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return Recipe
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Advert
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }
    
    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
    
    /**
     * Set author
     *
     * @param string $author
     *
     * @return Advert
     */
    public function setAuthor($author)
    {
        $this->author = $author;
        return $this;
    }
    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set level
     *
     * @param \TV\ChefBundle\Entity\Level $level
     *
     * @return Recipe
     */
    public function setLevel(\TV\ChefBundle\Entity\Level $level = null)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return Recipe
     */
    public function getLevel()
    {
        return $this->level;
    }
    
    /**
     * Set note
     *
     * @param integer $note
     *
     * @return Recipe
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return int
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set nbOfPers
     *
     * @param integer $nbOfPers
     *
     * @return Recipe
     */
    public function setNbOfPers($nbOfPers)
    {
        $this->nbOfPers = $nbOfPers;

        return $this;
    }

    /**
     * Get nbOfPers
     *
     * @return int
     */
    public function getNbOfPers()
    {
        return $this->nbOfPers;
    }

    /**
     * Set cookingTime
     *
     * @param string $cookingTime
     *
     * @return Recipe
     */
    public function setCookingTime($cookingTime)
    {
        $this->cookingTime = $cookingTime;

        return $this;
    }

    /**
     * Get cookingTime
     *
     * @return string
     */
    public function getCookingTime()
    {
        return $this->cookingTime;
    }

    /**
     * Set preparationTime
     *
     * @param string $preparationTime
     *
     * @return Recipe
     */
    public function setPreparationTime($preparationTime)
    {
        $this->preparationTime = $preparationTime;

        return $this;
    }

    /**
     * Get preparationTime
     *
     * @return string
     */
    public function getPreparationTime()
    {
        return $this->preparationTime;
    }

    /**
     * Set timeout
     *
     * @param string $timeout
     *
     * @return Recipe
     */
    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;

        return $this;
    }

    /**
     * Get timeout
     *
     * @return string
     */
    public function getTimeout()
    {
        return $this->timeout;
    }
    
    /**
     * Set image
     *
     * @param \TV\ChefBundle\Entity\Image $image
     *
     * @return User
     */
    public function setImage(Image $image = null)
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

    public function addStep(Step $step)
    {
        $this->steps[] = $step;
        
        $step->setRecipe($this);
        return($this);
    }

    public function removeStep(Step $step)
    {
        $this->steps->removeElement($step);
    }

    public function getSteps()
    {
        return $this->steps;
    }
    
    public function addIngredient(Ingredient $ingredient)
    {
        $this->ingredients[] = $ingredient;
        
        $ingredient->setRecipe($this);
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
    
    public function addType(Type $type)
    {
        $this->types[] = $type;
    }

    public function removeType(Type $type)
    {
        $this->types->removeElement($type);
    }

    public function getTypes()
    {
        return $this->types;
    }

    public function addCategory(Category $category)
    {
        $this->categories[] = $category;
    }

    public function removeCategory(Category $category)
    {
        $this->categories->removeElement($category);
    }

    public function getCategories()
    {
        return $this->categories;
    }

    public function addLocality(Locality $locality)
    {
        $this->localities[] = $locality;
    }

    public function removeLocality(Locality $locality)
    {
        $this->localities->removeElement($locality);
    }

    public function getLocalities()
    {
        return $this->localities;
    }
}

