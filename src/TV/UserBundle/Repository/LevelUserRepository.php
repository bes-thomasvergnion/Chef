<?php

namespace TV\UserBundle\Repository;

/**
 * LevelUserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class LevelUserRepository extends \Doctrine\ORM\EntityRepository
{
    public function getLevelsUser()
    {
        $query = $this->createQueryBuilder('a')
            ->orderBy('a.id', 'ASC')
            ->getQuery()
        ;
        return $query->getResult();
    }
}
