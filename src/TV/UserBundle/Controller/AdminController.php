<?php

namespace TV\UserBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class AdminController extends Controller
{
    /**
    * @Security("has_role('ROLE_ADMIN')")
    */
    public function indexAction()
    {
        $nbrRecipes = $this->getDoctrine()
            ->getManager()
            ->getRepository('TVChefBundle:Recipe')
            ->getNbrRecipes()
        ;
        
        $nbrUsers = $this->getDoctrine()
            ->getManager()
            ->getRepository('TVUserBundle:User')
            ->getNbrUsers()
        ;
        
        $currentUser = $this->container->get('security.token_storage')->getToken()->getUser();
        $lastLogin = $currentUser->getLastLogin();
        
        return $this->render('TVUserBundle:Admin:index.html.twig', array(
            'nbrRecipes' => $nbrRecipes,
            'nbrUsers' => $nbrUsers,
            'lastLogin' => $lastLogin
        ));
    }
    
    /**
    * @Security("has_role('ROLE_ADMIN')")
    */
    public function recipeAdminAction($page)
    {
        if ($page < 1) {
            throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        }
        
        $nbPerPage = 10;
        
        $listRecipes = $this->getDoctrine()
            ->getManager()
            ->getRepository('TVChefBundle:Recipe')
            ->getRecipesAdmin($page, $nbPerPage)
        ;
        
        $nbPages = ceil(count($listRecipes)/$nbPerPage);
        return $this->render('TVUserBundle:Admin:recipes-admin.html.twig', array(
            'listRecipes' => $listRecipes,
            'nbPages' => $nbPages,
            'page' => $page,
        ));
    }
    
    /**
    * @Security("has_role('ROLE_ADMIN')")
    */
    public function recipeUsersAction($page)
    {
        if ($page < 1) {
            throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        }
        
        $nbPerPage = 10;
        
        $listRecipes = $this->getDoctrine()
            ->getManager()
            ->getRepository('TVChefBundle:Recipe')
            ->getRecipesUsers($page, $nbPerPage)
        ;
        
        $nbPages = ceil(count($listRecipes)/$nbPerPage);
        return $this->render('TVUserBundle:Admin:recipes-admin.html.twig', array(
            'listRecipes' => $listRecipes,
            'nbPages' => $nbPages,
            'page' => $page,
        ));
    }
    
    /**
    * @Security("has_role('ROLE_ADMIN')")
    */
    public function usersAction($page)
    {
        if ($page < 1) {
            throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        }
        
        $nbPerPage = 10;
        
        $listUsers = $this->getDoctrine()
            ->getManager()
            ->getRepository('TVUserBundle:User')
            ->getUsers($page, $nbPerPage)
        ;
        
        $nbPages = ceil(count($listUsers)/$nbPerPage);
        return $this->render('TVUserBundle:Admin:users.html.twig', array(
            'listUsers' => $listUsers,
            'nbPages' => $nbPages,
            'page' => $page,
        ));
    }
    
}
