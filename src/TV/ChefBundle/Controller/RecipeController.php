<?php

namespace TV\ChefBundle\Controller;
use TV\ChefBundle\Entity\Recipe;
use TV\ChefBundle\Entity\Note;
use TV\ChefBundle\Form\RecipeType;
use TV\ChefBundle\Form\RecipeEditType;
use TV\ChefBundle\Form\NoteType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class RecipeController extends Controller
{
    public function indexAction($page)
    {
        if ($page < 1) {
            throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        }
        
        $count = 0;
        $nbPerPage = 18;
        
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
        $currentUser = $this->container->get('security.token_storage')->getToken()->getUser();
        
        $em = $this->getDoctrine()->getManager();

        $recipe = $em->getRepository('TVChefBundle:Recipe')->find($id);
        
        if (null === $recipe) {
            throw new NotFoundHttpException("La recette d'id ".$id." n'existe pas.");
        }
        return $this->render('TVChefBundle:Recipe:view.html.twig', array(
            'recipe' => $recipe,
            'currentUser' => $currentUser,
        ));
    }        
    
    /**
    * @Security("has_role('ROLE_USER')")
    */
    public function addAction(Request $request)
    {
        $recipe = new Recipe();
        
        $recipe->setAuthor($this->container->get('security.token_storage')->getToken()->getUser());
        
        $form = $this->get('form.factory')->create(RecipeType::class, $recipe);
        
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            
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
    
    /**
    * @Security("has_role('ROLE_USER')")
    */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $recipe = $em->getRepository('TVChefBundle:Recipe')->find($id);
        
        if (null === $recipe) {
            throw new NotFoundHttpException("La recette d'id ".$id." n'existe pas.");
        }
        
        $user = $recipe->getAuthor();
        $currentUser = $this->container->get('security.token_storage')->getToken()->getUser();
        if($currentUser == $user || $this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
            $form = $this->get('form.factory')->create(RecipeEditType::class, $recipe);
            if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
                $em->flush();
                $request->getSession()->getFlashBag()->add('notice', 'Recette bien modifiée.');
                return $this->redirectToRoute('tv_chef_recipe_view', array('id' => $recipe->getId()));
            }
            return $this->render('TVChefBundle:Recipe:edit.html.twig', array(
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
    public function deleteAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $recipe = $em->getRepository('TVChefBundle:Recipe')->find($id);
        if (null === $recipe) {
            throw new NotFoundHttpException("La recette d'id ".$id." n'existe pas.");
        }
        $form = $this->get('form.factory')->create();
        
        $user = $recipe->getAuthor();
        $currentUser = $this->container->get('security.token_storage')->getToken()->getUser();
        
        if($currentUser == $user || $this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
            if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
                $em->remove($recipe);
                $em->flush();
                $request->getSession()->getFlashBag()->add('info', "La recette a bien été supprimée.");
                return $this->redirectToRoute('tv_chef_homepage');
            }
            return $this->render('TVChefBundle:Recipe:delete.html.twig', array(
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
    public function noteAction($id, Request $request)
    {
        $note = new Note();
        
        $em = $this->getDoctrine()->getManager();
        $recipe = $em->getRepository('TVChefBundle:Recipe')->find($id);
        
        $note->setAuthor($this->container->get('security.token_storage')->getToken()->getUser());
        $note->setRecipe($recipe);
        
        $form = $this->get('form.factory')->create(NoteType::class, $note);
        
        $user = $recipe->getAuthor();
        $currentUser = $this->container->get('security.token_storage')->getToken()->getUser();
        
        if($currentUser != $user || $this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
            if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $em->persist($note);

                $nbr_notes = $this->getDoctrine()
                    ->getManager()
                    ->getRepository('TVChefBundle:Recipe')
                    ->getNbrNotes($recipe)
                ;

                $value_note = $note->getValue();

                if($nbr_notes[1] != 0){
                    $note_total = $recipe->getNote_total();
                    $note_total = $note_total + $value_note ;
                    $recipe->setNote_total($note_total);
                    $star = $note_total / ($nbr_notes[1] + 1);
                    $recipe->setStar($star);
                }
                else{
                    $recipe->setNote_total($value_note);
                    $recipe->setStar($value_note);
                }

                $em->flush();

                $request->getSession()->getFlashBag()->add('notice', 'Recette bien enregistrée.');
                return $this->redirectToRoute('tv_chef_recipe_view', array('id' => $recipe->getId()));
            }
        }
        
        return $this->render('TVChefBundle:Recipe:note.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
    public function printableAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $recipe = $em->getRepository('TVChefBundle:Recipe')->find($id);
        
        if (null === $recipe) {
            throw new NotFoundHttpException("La recette d'id ".$id." n'existe pas.");
        }
        return $this->render('TVChefBundle:Pages:printable.html.twig', array(
            'recipe' => $recipe,
        ));
    }
}