<?php

namespace TV\UserBundle\Controller;
use TV\UserBundle\Form\UserEditType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use TV\UserBundle\Form\NoteUserType;
use TV\UserBundle\Entity\NoteUser;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class UserController extends Controller
{
    public function indexAction($page)
    {
        if ($page < 1) {
            throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        }
        
        $titlePage = 'Les Cuistots';
        $count = 0;
        $nbPerPage = 15;
        
        $listUsers = $this->getDoctrine()
            ->getManager()
            ->getRepository('TVUserBundle:User')
            ->getActivedUsers($page, $nbPerPage)
        ;
        
        $nbPages = ceil(count($listUsers)/$nbPerPage);
        return $this->render('TVUserBundle:User:index.html.twig', array(
            'listUsers' => $listUsers,
            'nbPages' => $nbPages,
            'page' => $page,
            'titlePage' => $titlePage,
            'count' => $count,
        ));
    }
    
    
    public function viewAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $currentUser = $this->container->get('security.token_storage')->getToken()->getUser();
        $user = $em->getRepository('TVUserBundle:User')->find($id);
        
        $actived = $user->isEnabled();
        $count = 0;
        $count2 = 0;
        
        if (null === $user) {
            throw new NotFoundHttpException("L'utilisateur d'id ".$id." n'existe pas.");
        }
        
        if($actived === true || $this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
            return $this->render('TVUserBundle:User:view.html.twig', array(
                'currentUser' => $currentUser,
                'user' => $user,
                'count' => $count,
                'count2' => $count2,
            ));
        }
        else{
            return $this->redirectToRoute('tv_chef_homepage');
        }
    }        
    
    /**
    * @Security("has_role('ROLE_USER')")
    */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $currentUser = $this->container->get('security.token_storage')->getToken()->getUser();
        $user = $em->getRepository('TVUserBundle:User')->find($id);
        
        if (null === $user) {
            throw new NotFoundHttpException("L'utilisateur d'id ".$id." n'existe pas.");
        }
        
        if($currentUser == $user){
            $form = $this->get('form.factory')->create(UserEditType::class, $user);
            if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
                $image = $user->getImage();
                if(isset($image)){
                    $image->preUpload();
                }
                $em->flush();
                $request->getSession()->getFlashBag()->add('notice', 'Utilisateur bien modifiée.');
                return $this->redirectToRoute('tv_user_view', array('id' => $user->getId()));
            }
            return $this->render('TVUserBundle:User:edit.html.twig', array(
                'user' => $user,
                'form'   => $form->createView(),
            ));
          }
        else{
            return $this->redirectToRoute('tv_user_view', array('id' => $user->getId()));
        }
    }
    
    /**
    * @Security("has_role('ROLE_USER')")
    */
    public function deleteAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('TVUserBundle:User')->find($id);
        if (null === $user) {
            throw new NotFoundHttpException("L'utilisateur d'id ".$id." n'existe pas.");
        }
        $form = $this->get('form.factory')->create();
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->remove($user);
            $em->flush();
            $request->getSession()->getFlashBag()->add('info', "L'utilisateur a bien été supprimée.");
            return $this->redirectToRoute('tv_chef_homepage');
        }
        return $this->render('TVUserBundle:User:delete.html.twig', array(
            'user' => $user,
            'form'   => $form->createView(),
        ));
    }
       
    public function myRecipesAction($id)
    {
        $count = 0;
        
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('TVUserBundle:User')->find($id);
        return $this->render('TVUserBundle:User:my_recipes.html.twig', array(
            'count' => $count,
            'user' => $user,
        ));
    }
    
    /**
    * @Security("has_role('ROLE_ADMIN')")
    */
    public function bannishAction($id, Request $request) 
    {
        $em = $this->getDoctrine()->getManager(); 
        $user = $em->getRepository('TVUserBundle:User')->find($id);
        
        $hisadverts = $em->getRepository('TVFindyourbandBundle:Advert')->findByAuthor($user);
        
        $form = $this->get('form.factory')->create();
        
        
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            foreach($hisadverts as $hisadvert){
                $em->remove($hisadvert);
            }
            $user->setEnabled(false);
            $em->flush();
            
            return $this->redirectToRoute('tv_admin_users');
        }
        return $this->render('TVUserBundle:User:bannish.html.twig', array(
            'user' => $user,
            'form'   => $form->createView(),
        ));
    }
    
    /**
    * @Security("has_role('ROLE_USER')")
    */
    public function noteAction($id, Request $request)
    {
        $note = new NoteUser();
        
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('TVUserBundle:User')->find($id);
        
        $note->setAuthor($this->container->get('security.token_storage')->getToken()->getUser());
        $note->setUser($user);
        
        $form = $this->get('form.factory')->create(NoteUserType::class, $note);
        
        $currentUser = $this->container->get('security.token_storage')->getToken()->getUser();
        
        if($currentUser != $user || $this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
            if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $em->persist($note);

                $nbr_notes = $this->getDoctrine()
                    ->getManager()
                    ->getRepository('TVUserBundle:User')
                    ->getNbrNotes($user)
                ;

                $value_note = $note->getValue();

                if($nbr_notes[1] != 0){
                    $note_total = $user->getNote_total();
                    $note_total = $note_total + $value_note ;
                    $user->setNote_total($note_total);
                    $star = $note_total / ($nbr_notes[1] + 1);
                    $user->setStar($star);
                }
                else{
                    $user->setNote_total($value_note);
                    $user->setStar($value_note);
                }

                $em->flush();

                $request->getSession()->getFlashBag()->add('notice', 'Note bien enregistrée.');
                return $this->redirectToRoute('tv_user_view', array('id' => $user->getId()));
            }
        }
        
        return $this->render('TVUserBundle:User:note.html.twig', array(
            'form' => $form->createView(),
        ));
        
    }
}
