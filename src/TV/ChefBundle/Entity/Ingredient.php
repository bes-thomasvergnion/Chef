<?php

namespace TV\ChefBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ingredient
 *
 * @ORM\Table(name="ingredient")
 * @ORM\Entity(repositoryClass="TV\ChefBundle\Repository\IngredientRepository")
 */
class Ingredient
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
     * @var string
     *
     * @ORM\Column(name="quantity", type="string", length=255)
     */
    private $quantity;
    
    /**
     * @ORM\ManyToOne(targetEntity="TV\ChefBundle\Entity\TypeQuantity")
     * @ORM\JoinColumn(nullable=true)
     */
    private $typequantity;
    
    /**
     * @ORM\ManyToOne(targetEntity="TV\ChefBundle\Entity\Recipe", inversedBy="ingredients")
     * @ORM\JoinColumn(nullable=false)
     */
    private $recipe;
    
    /**
     * @ORM\ManyToOne(targetEntity="TV\ChefBundle\Entity\Liste", inversedBy="ingredients")
     * @ORM\JoinColumn(nullable=true)
     */
    private $liste;

    


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
     * @return Ingredient
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
     * Set quantity
     *
     * @param string $quantity
     *
     * @return Ingredient
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return string
     */
    public function getQuantity()
    {
        return $this->quantity;
    }
    
    /**
     * Set recipe
     *
     * @param \TV\ChefBundle\Entity\Recipe $recipe
     *
     * @return Step
     */
    public function setRecipe(\TV\ChefBundle\Entity\Recipe $recipe)
    {
        $this->recipe = $recipe;

        return $this;
    }

    /**
     * Get recipe
     *
     * @return \TV\ChefBundle\Entity\Recipe
     */
    public function getRecipe()
    {
        return $this->recipe;
    }
    
    /**
     * Set typequantity
     *
     * @param \TV\ChefBundle\Entity\TypeQuantity $typequantity
     *
     * @return TypeQuantity
     */
    public function setTypequantity(\TV\ChefBundle\Entity\TypeQuantity $typequantity)
    {
        $this->typequantity = $typequantity;

        return $this;
    }

    /**
     * Get typequantity
     *
     * @return \TV\ChefBundle\Entity\TypeQuantity
     */
    public function getTypequantity()
    {
        return $this->typequantity;
    }
    

    /**
     * Set liste
     *
     * @param \TV\ChefBundle\Entity\Liste $liste
     *
     * @return Ingredient
     */
    public function setListe(\TV\ChefBundle\Entity\Liste $liste)
    {
        $this->liste = $liste;

        return $this;
    }

    /**
     * Get liste
     *
     * @return \TV\ChefBundle\Entity\Liste
     */
    public function getListe()
    {
        return $this->liste;
    }
}
