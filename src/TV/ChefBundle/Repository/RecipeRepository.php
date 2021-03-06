<?php

namespace TV\ChefBundle\Repository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * RecipeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RecipeRepository extends \Doctrine\ORM\EntityRepository
{
    public function listeRecipes($term)
    {
        $qb = $this->createQueryBuilder('c');
         
        $qb ->select('c.name')
            ->where('c.name LIKE :term')
            ->setParameter('term', '%'.$term.'%');
         
        $arrayAss= $qb->getQuery()->getArrayResult();     
        
        $array = array();
        foreach($arrayAss as $data)
        {
            $array[] = $data['name'];
        }
     
        return $array;      
    }
    
    public function getRecipes($page, $nbPerPage)
    {
        $query = $this->createQueryBuilder('a')
            ->orderBy('a.id', 'DESC')
            ->getQuery()
        ;
        
        $query
            ->setFirstResult(($page-1) * $nbPerPage)
            ->setMaxResults($nbPerPage)
          ;
        return new Paginator($query, true);
    }
    
    public function getRecipesWithSearch(\TV\ChefBundle\Entity\Search $search, $page, $nbPerPage)
    {
        $query = $this->createQueryBuilder('a')
            ->where('a.name LIKE :search')
            ->setParameter('search', '%' .$search->getValue(). '%')
            ->orderBy('a.id', 'DESC')
            ->getQuery()
        ;
        
        $query
            ->setFirstResult(($page-1) * $nbPerPage)
            ->setMaxResults($nbPerPage)
          ;
        return new Paginator($query, true);
    }
    
    public function getRecipesWithFilters(\TV\ChefBundle\Entity\Filter $filter, $page, $nbPerPage)
    {            
        $query = $this->createQueryBuilder('g');
        $andX = $query->expr()->andX();
        
        if(null !== $filter->getType()){
            $query->leftJoin('g.types','t');
            $andX->add('t = :type');
            $query->setParameter('type', $filter->getType());
        }
        if(null !== $filter->getCategory()){
            $query->leftJoin('g.categories','c');
            $andX->add('c = :category');
            $query->setParameter('category', $filter->getCategory());
        }
        if(null !== $filter->getLocality()){
            $query->leftJoin('g.localities','l');
            $andX->add('l = :locality');
            $query->setParameter('locality', $filter->getLocality());
        }
        
        if(!empty($filter->getType()) || !empty($filter->getCategory()) || !empty($filter->getLocality()) ){
            $query->where($andX);
        }
        $query->orderBy('g.id', 'DESC');
        
        $query
            ->setFirstResult(($page-1) * $nbPerPage)
            ->setMaxResults($nbPerPage)
          ;
        return new Paginator($query, true);
    }
    
    public function getRecipesAdmin($page, $nbPerPage)
    {
        $role = "ROLE_SUPER_ADMIN";
        $query = $this->createQueryBuilder('a')
            ->innerJoin('a.author', 'c')
            ->addSelect('c')
            ->where('c.roles LIKE :role')
            ->setParameter('role', '%' .$role. '%')
            ->orderBy('a.id', 'DESC')
            ->getQuery()
        ;
        
        $query
            ->setFirstResult(($page-1) * $nbPerPage)
            ->setMaxResults($nbPerPage)
          ;
        return new Paginator($query, true);
    }
    
    public function getRecipesUsers($page, $nbPerPage)
    {
        $role = "ROLE_SUPER_ADMIN";
        $query = $this->createQueryBuilder('a')
            ->innerJoin('a.author', 'c')
            ->addSelect('c')
            ->where('c.roles NOT LIKE :role')
            ->setParameter('role', '%' .$role. '%')
            ->orderBy('a.id', 'DESC')
            ->getQuery()
        ;
        
        $query
            ->setFirstResult(($page-1) * $nbPerPage)
            ->setMaxResults($nbPerPage)
          ;
        return new Paginator($query, true);
    }
    
    public function getRecipesLocal()
    {
        $query = $this->createQueryBuilder('a')
            ->leftJoin('a.categories', 'c')
            ->addSelect('c')
            ->where('c.id=3')
            ->orderBy('a.date', 'DESC')
            ->setMaxResults(3)
            ->getQuery()
        ;

        return $query->getResult();
    }
    
    public function getRecipesVegan()
    {
        $query = $this->createQueryBuilder('a')
             ->leftJoin('a.categories', 'c')
            ->addSelect('c')
            ->where('c.id=2')
            ->orderBy('a.date', 'DESC')
            ->setMaxResults(3)
            ->getQuery()
        ;

        return $query->getResult();
    }
    
    public function getRecipesGluten()
    {
        $query = $this->createQueryBuilder('a')
            ->leftJoin('a.categories', 'c')
            ->addSelect('c')
            ->where('c.id=4')
            ->orderBy('a.date', 'DESC')
            ->setMaxResults(3)
            ->getQuery()
        ;

        return $query->getResult();
    }
    
    public function getNbrNotes($recipe)
    {
        $query = $this->createQueryBuilder('a')
            ->leftJoin('a.notes', 'c')
            ->addSelect('COUNT(c)')
            ->where('c.recipe = :recipe')
            ->setParameter('recipe', $recipe)
            ->getQuery()
        ;

        return $query->getSingleResult();
    }
    
    public function getRecipesOfNotebook($user)
    {
        $query = $this->createQueryBuilder('a')
            ->leftJoin('a.notebooks', 'c')
            ->addSelect('c')
            ->where('c.user = :user')
            ->setParameter('user', $user)
            
            ->getQuery()
        ;
        
        return $query->getResult();
    }
    
    public function getNbrRecipes()
    {
        return $this->createQueryBuilder('a')
                        ->select('COUNT(a)')
                        ->getQuery()
                        ->getSingleScalarResult();
    }
    
}
