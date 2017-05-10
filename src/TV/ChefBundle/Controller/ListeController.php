<?php

namespace TV\ChefBundle\Controller;
use TV\ChefBundle\Entity\Liste;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class ListeController extends Controller
{
    public function indexAction()
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $liste = $user->getListe();
        
        return $this->render('TVChefBundle:Pages:shopping-list.html.twig', array(
            'liste' => $liste,
            'user' => $user,
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
        
        $ingredients = $recipe->getIngredients();
        
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        
        $liste = $user->getListe();
        
        if ($liste === null){
            $liste = new Liste();
            $user->setListe($liste);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($liste);
            
        }
        
        foreach ($ingredients as $ingredient){
            $liste->addIngredient($ingredient);
        }
        
        $em->flush();
        
        return $this->redirectToRoute('tv_chef_liste_index');       
    }
    
    /**
    * @Security("has_role('ROLE_USER')")
    */
    public function deleteAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $liste = $em->getRepository('TVChefBundle:Liste')->find($id);
        $ingredients = $liste->getIngredients();

        $user = $liste->getUser();
        $currentUser = $this->container->get('security.token_storage')->getToken()->getUser();
        
        if($currentUser == $user || $this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
            foreach ($ingredients as $ingredient){
                $em->remove($ingredient);
            }
            $em->flush();
            $request->getSession()->getFlashBag()->add('info', "La liste a bien été supprimée.");
            return $this->redirectToRoute('tv_chef_liste_index');
            
        }
        else{
            return $this->redirectToRoute('tv_chef_liste_index');
        }
    }
    
    /**
    * @Security("has_role('ROLE_USER')")
    */
    public function deleteIngredientAction($id, $id_liste, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $liste = $em->getRepository('TVChefBundle:Liste')->find($id_liste);
        $ingredient = $em->getRepository('TVChefBundle:Ingredient')->find($id);

        $user = $liste->getUser();
        $currentUser = $this->container->get('security.token_storage')->getToken()->getUser();
        
        if($currentUser == $user || $this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
            
            $liste->removeIngredient($ingredient);
            $em->persist($liste);
            $em->flush();
            $request->getSession()->getFlashBag()->add('info', "L'ingrédient a bien été supprimé.");
            return $this->redirectToRoute('tv_chef_liste_index');
            
        }
        else{
            return $this->redirectToRoute('tv_chef_liste_index');
        }
    }
    
}
