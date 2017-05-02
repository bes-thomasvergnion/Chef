<?php

namespace TV\ChefBundle\Controller;
use TV\ChefBundle\Entity\Step;
use TV\ChefBundle\Form\StepType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class StepController extends Controller
{  
    /**
    * @Security("has_role('ROLE_USER')")
    */
    public function addAction($id, Request $request)
    {
        $step = new Step();
        
        $em = $this->getDoctrine()->getManager();
        $recipe = $em->getRepository('TVChefBundle:Recipe')->find($id);
        
        if (null === $recipe) {
            throw new NotFoundHttpException("La recette d'id ".$id." n'existe pas.");
        }
        
        $user = $recipe->getAuthor();
        $currentUser = $this->container->get('security.token_storage')->getToken()->getUser();
        
        if($currentUser == $user || $this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
            $form = $this->get('form.factory')->create(StepType::class, $step);
            if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
                $recipe->addStep($step);
                $em->persist($step);
                $em->flush();
                $request->getSession()->getFlashBag()->add('notice', 'Recette bien modifiée.');
                return $this->redirectToRoute('tv_chef_recipe_view', array('id' => $recipe->getId()));
            }
            return $this->render('TVChefBundle:Step:add.html.twig', array(
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
        $step = $em->getRepository('TVChefBundle:Step')->find($id);
        $recipe = $em->getRepository('TVChefBundle:Recipe')->find($id_recipe);
        
        if (null === $step) {
            throw new NotFoundHttpException("L'étape d'id ".$id." n'existe pas.");
        }
        
        $user = $recipe->getAuthor();
        $currentUser = $this->container->get('security.token_storage')->getToken()->getUser();
        if($currentUser == $user || $this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
            $form = $this->get('form.factory')->create(StepType::class, $step);
            if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
                $em->flush();
                $request->getSession()->getFlashBag()->add('notice', 'Etape bien modifiée.');
                return $this->redirectToRoute('tv_chef_recipe_view', array('id' => $recipe->getId()));
            }
            return $this->render('TVChefBundle:Step:edit.html.twig', array(
                'step' => $step,
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
        $step = $em->getRepository('TVChefBundle:Step')->find($id);
        $recipe = $em->getRepository('TVChefBundle:Recipe')->find($id_recipe);
        
        if (null === $step) {
            throw new NotFoundHttpException("L'étape d'id ".$id." n'existe pas.");
        }
        
        $user = $recipe->getAuthor();
        $currentUser = $this->container->get('security.token_storage')->getToken()->getUser();
        
        $form = $this->get('form.factory')->create();
        
        if($currentUser == $user || $this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
            if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
                $em->remove($step);
                $em->flush();
                $request->getSession()->getFlashBag()->add('info', "L'étape a bien été supprimée.");
                return $this->redirectToRoute('tv_chef_recipe_view', array('id' => $recipe->getId()));
            }
            return $this->render('TVChefBundle:Step:delete.html.twig', array(
                'recipe' => $recipe,
                'step' => $step,
                'form'   => $form->createView(),
            ));
        }
        else{
            return $this->redirectToRoute('tv_chef_recipe_view', array('id' => $recipe->getId()));
        }
    }
    
    
}