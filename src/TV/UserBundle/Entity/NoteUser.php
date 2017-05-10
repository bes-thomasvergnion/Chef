<?php

namespace TV\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * NoteUser
 *
 * @ORM\Table(name="note_user")
 * @ORM\Entity(repositoryClass="TV\UserBundle\Repository\NoteUserRepository")
 */
class NoteUser
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
     * @ORM\ManyToOne(targetEntity="TV\UserBundle\Entity\User", inversedBy="notes")
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;
    
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
     * @return NoteUser
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
     * Set user
     *
     * @param \TV\UserBundle\Entity\User $user
     *
     * @return NoteUser
     */
    public function setUser(\TV\UserBundle\Entity\User $user)
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
    
    /**
     * Set author
     *
     * @param string $author
     *
     * @return NoteUser
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

