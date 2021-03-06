<?php

namespace TV\UserBundle\Repository;

/**
 * FollowRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FollowRepository extends \Doctrine\ORM\EntityRepository
{
    public function getFollow($followed, $follower)
    {
        $query = $this->createQueryBuilder('a')
            ->where('a.followed = :followed')
            ->setParameter('followed', $followed)
            ->andWhere('a.follower = :follower')
            ->setParameter('follower', $follower)
            ->getQuery()
        ;
        return $query->getSingleResult();
    }
}
