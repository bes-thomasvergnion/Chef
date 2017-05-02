<?php

namespace TV\ChefBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Filter
 *
 * @ORM\Table(name="filter")
 * @ORM\Entity(repositoryClass="TV\ChefBundle\Repository\FilterRepository")
 */
class Filter
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
     * @ORM\ManyToOne(targetEntity="TV\ChefBundle\Entity\Type", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $type;
    
    /**
     * @ORM\ManyToOne(targetEntity="TV\ChefBundle\Entity\Category", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $category;
    
    /**
     * @ORM\ManyToOne(targetEntity="TV\ChefBundle\Entity\Locality", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $locality;
    


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
     * Set type
     *
     * @param \TV\ChefBundle\Entity\Type $type
     *
     * @return Filter
     */
    public function setType(\TV\ChefBundle\Entity\Type $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \TV\ChefBundle\Entity\Type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set category
     *
     * @param \TV\ChefBundle\Entity\Category $category
     *
     * @return Filter
     */
    public function setCategory(\TV\ChefBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \TV\ChefBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set locality
     *
     * @param \TV\ChefBundle\Entity\Locality $locality
     *
     * @return Filter
     */
    public function setLocality(\TV\ChefBundle\Entity\Locality $locality = null)
    {
        $this->locality = $locality;

        return $this;
    }

    /**
     * Get locality
     *
     * @return \TV\ChefBundle\Entity\Locality
     */
    public function getLocality()
    {
        return $this->locality;
    }
}
