<?php

namespace TV\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Follow
 *
 * @ORM\Table(name="follow")
 * @ORM\Entity(repositoryClass="TV\UserBundle\Repository\FollowRepository")
 */
class Follow
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
     * @ORM\ManyToOne(targetEntity="TV\UserBundle\Entity\User", inversedBy="followeds")
     * @ORM\JoinColumn(nullable=true)
     */
    private $followed;
    
    /**
     * @ORM\ManyToOne(targetEntity="TV\UserBundle\Entity\User", inversedBy="followers")
     * @ORM\JoinColumn(nullable=true)
     */
    private $follower;


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
     * Set followed
     *
     * @param \TV\UserBundle\Entity\User $followed
     *
     * @return Follow
     */
    public function setFollowed(\TV\UserBundle\Entity\User $followed)
    {
        $this->followed = $followed;

        return $this;
    }

    /**
     * Get followed
     *
     * @return \TV\UserBundle\Entity\User
     */
    public function getFollowed()
    {
        return $this->followed;
    }
    
    /**
     * Set follower
     *
     * @param \TV\UserBundle\Entity\User $follower
     *
     * @return Follow
     */
    public function setFollower(\TV\UserBundle\Entity\User $follower)
    {
        $this->follower = $follower;

        return $this;
    }

    /**
     * Get follower
     *
     * @return \TV\UserBundle\Entity\User
     */
    public function getFollower()
    {
        return $this->follower;
    }
}

