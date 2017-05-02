<?php

namespace TV\ChefBundle\Controller;
use TV\ChefBundle\Entity\Ingredient;
use TV\ChefBundle\Form\IngredientType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class IngredientController extends Controller
{  
    /**
    * @Security("has_role('ROLE_USER')")
    */
    public function addAction($id, Request $request)
    {
        $ingredient = new Ingredient();
        
        $em = $this->getDoctrine()->getManager();
        $recipe = $em->getRepository('TVChefBundle:Recipe')->find($id);
        
        if (null === $recipe) {
            throw new NotFoundHttpException("La recette d'id ".$id." n'existe pas.");
        }
        
        $user = $recipe->getAuthor();
        $currentUser = $this->container->get('security.token_storage')->getToken()->getUser();
        
        if($currentUser == $user || $this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
            $form = $this->get('form.factory')->create(IngredientType::class, $ingredient);
            if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
                $recipe->addIngredient($ingredient);
                $em->persist($ingredient);
                $em->flush();
                $request->getSession()->getFlashBag()->add('notice', 'Recette bien modifiée.');
                return $this->redirectToRoute('tv_chef_recipe_view', array('id' => $recipe->getId()));
            }
            return $this->render('TVChefBundle:Ingredient:add.html.twig', array(
                'recipe' => $recipe,
                'form'   => $form->createView(),
            ));
        }
        else{
            return $this->redirectToRoute('tv_chef_recipe_view', array('id' => $recipe->getId()));
        }
    }
    
    /**
    * @Security("has_role('ROLE_USER')")
    */
    public function editAction($id, $id_recipe, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $ingredient = $em->getRepository('TVChefBundle:Ingredient')->find($id);
        $recipe = $em->getRepository('TVChefBundle:Recipe')->find($id_recipe);
        
        if (null === $ingredient) {
            throw new NotFoundHttpException("L'ingrédient d'id ".$id." n'existe pas.");
        }
        
        $user = $recipe->getAuthor();
        $currentUser = $this->container->get('security.token_storage')->getToken()->getUser();
        if($currentUser == $user || $this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
            $form = $this->get('form.factory')->create(IngredientType::class, $ingredient);
            if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
                $em->flush();
                $request->getSession()->getFlashBag()->add('notice', 'Ingrédient bien modifié.');
                return $this->redirectToRoute('tv_chef_recipe_view', array('id' => $recipe->getId()));
            }
            return $this->render('TVChefBundle:Ingredient:edit.html.twig', array(
                'ingredient' => $ingredient,
                'form'   => $form->createView(),
            ));
        }
        else{
            return $this->redirectToRoute('tv_chef_recipe_view', array('id' => $recipe->getId()));
        }
    }
    
    /**
    * @Security("has_role('ROLE_USER')")
    */
    public function deleteAction($id, $id_recipe, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $ingredient = $em->getRepository('TVChefBundle:Ingredient')->find($id);
        $recipe = $em->getRepository('TVChefBundle:Recipe')->find($id_recipe);
        
        if (null === $ingredient) {
            throw new NotFoundHttpException("L'ingrédient d'id ".$id." n'existe pas.");
        }
        
        $user = $recipe->getAuthor();
        $currentUser = $this->container->get('security.token_storage')->getToken()->getUser();
        
        $form = $this->get('form.factory')->create();
        
        if($currentUser == $user || $this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
            if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
                $em->remove($ingredient);
                $em->flush();
                $request->getSession()->getFlashBag()->add('info', "L'ingrédient a bien été supprimé.");
                return $this->redirectToRoute('tv_chef_recipe_view', array('id' => $recipe->getId()));
            }
            return $this->render('TVChefBundle:Ingredient:delete.html.twig', array(
                'recipe' => $recipe,
                'ingredient' => $ingredient,
                'form'   => $form->createView(),
            ));
        }
        else{
            return $this->redirectToRoute('tv_chef_recipe_view', array('id' => $recipe->getId()));
        }
    }
}