<?php

namespace TV\ChefBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Note
 *
 * @ORM\Table(name="note")
 * @ORM\Entity(repositoryClass="TV\ChefBundle\Repository\NoteRepository")
 */
class Note
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
     * @var int
     *
     * @ORM\Column(name="value", type="integer")
     */
    private $value;
    
    /**
     * @ORM\ManyToOne(targetEntity="TV\ChefBundle\Entity\Recipe", inversedBy="notes")
     * @ORM\JoinColumn(nullable=true)
     */
    private $recipe;
    
    /**
     * @ORM\ManyToOne(targetEntity="TV\UserBundle\Entity\User", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $author;


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
     * Set value
     *
     * @param integer $value
     *
     * @return Note
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }
    
    /**
     * Set recipe
     *
     * @param \TV\ChefBundle\Entity\Recipe $recipe
     *
     * @return Note
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
     * Set author
     *
     * @param string $author
     *
     * @return Note
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
}

