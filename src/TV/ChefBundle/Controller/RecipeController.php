<?php

namespace TV\ChefBundle\Controller;
use TV\ChefBundle\Entity\Recipe;
use TV\ChefBundle\Form\RecipeType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class RecipeController extends Controller
{
    public function indexAction($page)
    {
        if ($page < 1) {
            throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        }
        
        $count = 0;
        $nbPerPage = 5;
        
        $listRecipes = $this->getDoctrine()
            ->getManager()
            ->getRepository('TVChefBundle:Recipe')
            ->getRecipes($page, $nbPerPage)
        ;
        
        $nbPages = ceil(count($listRecipes)/$nbPerPage);
        
        if ($page > $nbPages) {
            throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        }
        
        return $this->render('TVChefBundle:Recipe:index.html.twig', array(
            'listRecipes' => $listRecipes,
            'nbPages' => $nbPages,
            'page' => $page,
            'count' => $count
        ));
    }
    
    public function viewAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $recipe = $em->getRepository('TVChefBundle:Recipe')->find($id);
        if (null === $recipe) {
            throw new NotFoundHttpException("La recette d'id ".$id." n'existe pas.");
        }
        return $this->render('TVChefBundle:Recipe:view.html.twig', array(
            'recipe' => $recipe,
        ));
    }        
    
    public function addAction(Request $request)
    {
        $recipe = new Recipe();
        
//        $recipe->setAuthor($this->container->get('security.token_storage')->getToken()->getUser());
        
        $form = $this->get('form.factory')->create(RecipeType::class, $recipe);
        
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            
            $steps = $form->get('steps')->getData();
            $ingredients = $form->get('ingredients')->getData();
     
            foreach($steps as $step)
            {
                $step->setRecipe($recipe);
            }
            
            foreach($ingredients as $ingredient)
            {
                $ingredient->setRecipe($recipe);
            }
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($recipe);
            $em->flush();
            
            $request->getSession()->getFlashBag()->add('notice', 'Recette bien enregistrée.');
            return $this->redirectToRoute('tv_chef_recipe_view', array('id' => $recipe->getId()));
        }
        
        return $this->render('TVChefBundle:Recipe:add.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
    public function editAction($id, Request $request)
    {
//        $em = $this->getDoctrine()->getManager();
//        $advert = $em->getRepository('TVFindyourbandBundle:Advert')->find($id);
//        
//        if (null === $advert) {
//            throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
//        }
//        
//        $user = $advert->getAuthor();
//        $currentUser = $this->container->get('security.token_storage')->getToken()->getUser();
//        if($currentUser == $user || $this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
//            $form = $this->get('form.factory')->create(AdvertEditType::class, $advert);
//            if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
//                $em->flush();
//                $request->getSession()->getFlashBag()->add('notice', 'Annonce bien modifiée.');
//                return $this->redirectToRoute('tv_findyourband_adverts_view', array('id' => $advert->getId()));
//            }
//            return $this->render('TVFindyourbandBundle:Advert:edit.html.twig', array(
//                'advert' => $advert,
//                'form'   => $form->createView(),
//            ));
//        }
//        else{
//            return $this->redirectToRoute('tv_findyourband_adverts_view', array('id' => $advert->getId()));
//        }
    }
    
    public function deleteAction($id, Request $request)
    {
//        $em = $this->getDoctrine()->getManager();
//        $advert = $em->getRepository('TVFindyourbandBundle:Advert')->find($id);
//        if (null === $advert) {
//            throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
//        }
//        $form = $this->get('form.factory')->create();
//        
//        $user = $advert->getAuthor();
//        $currentUser = $this->container->get('security.token_storage')->getToken()->getUser();
//        
//        if($currentUser == $user || $this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
//            if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
//                $em->remove($advert);
//                $em->flush();
//                $request->getSession()->getFlashBag()->add('info', "L'annonce a bien été supprimée.");
//                return $this->redirectToRoute('tv_findyourband_homepage');
//            }
//            return $this->render('TVFindyourbandBundle:Advert:delete.html.twig', array(
//                'advert' => $advert,
//                'form'   => $form->createView(),
//            ));
//        }
//        else{
//            return $this->redirectToRoute('tv_findyourband_adverts_view', array('id' => $advert->getId()));
//        }
    }
}