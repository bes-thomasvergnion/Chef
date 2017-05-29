<?php

namespace TV\ChefBundle\Controller;
use TV\ChefBundle\Entity\Notebook;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class NotebookController extends Controller
{
    public function indexAction()
    {
        $count = 0;
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        
        $listRecipes = $this->getDoctrine()
            ->getManager()
            ->getRepository('TVChefBundle:Recipe')
            ->getRecipesOfNotebook($user)
        ;
        
        return $this->render('TVChefBundle:Recipe:notebook.html.twig', array(
            'listRecipes' => $listRecipes,
            'count' => $count
        ));
    }     
    
    /**
    * @Security("has_role('ROLE_USER')")
    */
    public function addAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $recipe = $em->getRepository('TVChefBundle:Recipe')->find($id);
        
        if (null === $recipe) {
            throw new NotFoundHttpException("La recette d'id ".$id." n'existe pas.");
        }
        
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        
        $notebook = $user->getNotebook();
        
        if ($notebook == null){
            $notebook = new Notebook();
            $user->setNotebook($notebook);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($notebook);
            
        }
        
        $notebook->addRecipe($recipe);
        
        $em->flush();
        
        return $this->redirectToRoute('tv_chef_notebook_index');       
    }
    
    /**
    * @Security("has_role('ROLE_USER')")
    */
    public function deleteAction($id, Request $request)
    {
        $currentUser = $this->container->get('security.token_storage')->getToken()->getUser();
        
        $notebook = $currentUser->getNotebook();
        
        $em = $this->getDoctrine()->getManager();
        $recipe = $em->getRepository('TVChefBundle:Recipe')->find($id);
        
        $notebook->removeRecipe($recipe);
        
        $em->flush();
        
        return $this->redirectToRoute('tv_chef_notebook_index');
    }
    
}
