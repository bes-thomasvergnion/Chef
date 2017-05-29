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
    
    /**
     * @var integer
     *
     * @ORM\Column(name="star", type="integer", nullable=true)
     */
    private $star;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="note_total", type="integer", nullable=true)
     */
    private $note_total;
    
    /**
     * @ORM\OneToMany(targetEntity="TV\UserBundle\Entity\NoteUser", mappedBy="user", cascade={"persist"}, cascade={"remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $notes;
    
    /**
     * @ORM\OneToOne(targetEntity="TV\ChefBundle\Entity\Notebook", mappedBy="user")
     * @ORM\JoinColumn(nullable=true)
     */
    private $notebook;
    
    /**
     * @ORM\OneToOne(targetEntity="TV\ChefBundle\Entity\Liste", mappedBy="user", cascade={"remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $liste;
    
    /**
     * @ORM\OneToMany(targetEntity="TV\UserBundle\Entity\Follow", mappedBy="follower", cascade={"persist"}, cascade={"remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $followers;
    
    /**
     * @ORM\OneToMany(targetEntity="TV\UserBundle\Entity\Follow", mappedBy="followed", cascade={"persist"}, cascade={"remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $followeds;
    
    
    
    public function __construct()
    {
        $this->recipes = new ArrayCollection();
        $this->notes = new ArrayCollection();
        $this->followers = new ArrayCollection();
        $this->followeds = new ArrayCollection();
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
    
    /**
     * Set star
     *
     * @param integer $star
     *
     * @return User
     */
    public function setStar($star)
    {
        $this->star = $star;

        return $this;
    }

    /**
     * Get star
     *
     * @return integer
     */
    public function getStar()
    {
        return $this->star;
    }
    
    /**
     * Set note_total
     *
     * @param integer $note_total
     *
     * @return User
     */
    public function setNote_total($note_total)
    {
        $this->note_total = $note_total;

        return $this;
    }

    /**
     * Get note_total
     *
     * @return integer
     */
    public function getNote_total()
    {
        return $this->note_total;
    }
    
    public function addNote(NoteUser $note)
    {
        $this->notes[] = $note;
        
        $note->setUser($this);
        return($this);
    }
    
    public function removeNote(NoteUser $note)
    {
        $this->notes->removeElement($note);
    }

    public function getNotes()
    {
        return $this->note;
    }

    /**
     * Set noteTotal
     *
     * @param integer $noteTotal
     *
     * @return User
     */
    public function setNoteTotal($noteTotal)
    {
        $this->note_total = $noteTotal;

        return $this;
    }

    /**
     * Get noteTotal
     *
     * @return integer
     */
    public function getNoteTotal()
    {
        return $this->note_total;
    }

    /**
     * Set notebook
     *
     * @param \TV\ChefBundle\Entity\Notebook $notebook
     *
     * @return User
     */
    public function setNotebook(\TV\ChefBundle\Entity\Notebook $notebook = null)
    {
        $this->notebook = $notebook;
        $notebook->setUser($this);
        return $this;
    }

    /**
     * Get notebook
     *
     * @return \TV\ChefBundle\Entity\Notebook
     */
    public function getNotebook()
    {
        return $this->notebook;
    }
    
    /**
     * Set liste
     *
     * @param \TV\ChefBundle\Entity\Liste $liste
     *
     * @return User
     */
    public function setListe(\TV\ChefBundle\Entity\Liste $liste = null)
    {
        $this->liste = $liste;
        $liste->setUser($this);
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
    
    public function addFollower(\TV\UserBundle\Entity\Follow $follower)
    {
        $this->followers[] = $follower;
        
        $follower->setFollower($this);
        return($this);
    }
    
    public function removeFollower(\TV\UserBundle\Entity\Follow $follower)
    {
        $this->followers->removeElement($follower);
    }

    public function getFollowers()
    {
        return $this->followers;
    }
    
    public function addFollowed(\TV\UserBundle\Entity\Follow $followed)
    {
        $this->followeds[] = $followed;
        
        $followed->setFollowed($this);
        return $this;
    }
    
    public function removeFollowed(\TV\UserBundle\Entity\Follow $followed)
    {
        $this->followeds->removeElement($followed);
    }

    public function getFolloweds()
    {
        return $this->followeds;
    }
    
}
