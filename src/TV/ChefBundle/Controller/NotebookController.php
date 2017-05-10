<?php

namespace TV\ChefBundle\Controller;
use TV\ChefBundle\Entity\Notebook;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class NotebookController extends Controller
{
    public function indexAction($page)
    {
        if ($page < 1) {
            throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        }
        
        $count = 0;
        $nbPerPage = 6;
        
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        
        $listRecipes = $this->getDoctrine()
            ->getManager()
            ->getRepository('TVChefBundle:Recipe')
            ->getRecipesOfNotebook($page, $nbPerPage, $user)
        ;
        
        $nbPages = ceil(count($listRecipes)/$nbPerPage);
        
        if ($page > $nbPages) {
            throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        }
        
        return $this->render('TVChefBundle:Recipe:notebook.html.twig', array(
            'listRecipes' => $listRecipes,
            'nbPages' => $nbPages,
            'page' => $page,
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
//    public function deleteAction($id, Request $request)
//    {
//        $em = $this->getDoctrine()->getManager();
//        $recipe = $em->getRepository('TVChefBundle:Recipe')->find($id);
//        if (null === $recipe) {
//            throw new NotFoundHttpException("La recette d'id ".$id." n'existe pas.");
//        }
//        $form = $this->get('form.factory')->create();
//        
//        $user = $recipe->getAuthor();
//        $currentUser = $this->container->get('security.token_storage')->getToken()->getUser();
//        
//        if($currentUser == $user || $this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
//            if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
//                $em->remove($recipe);
//                $em->flush();
//                $request->getSession()->getFlashBag()->add('info', "La recette a bien été supprimée.");
//                return $this->redirectToRoute('tv_chef_homepage');
//            }
//            return $this->render('TVChefBundle:Recipe:delete.html.twig', array(
//                'recipe' => $recipe,
//                'form'   => $form->createView(),
//            ));
//        }
//        else{
//            return $this->redirectToRoute('tv_chef_recipe_view', array('id' => $recipe->getId()));
//        }
//    }
    
}