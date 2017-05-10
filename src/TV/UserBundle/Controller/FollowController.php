<?php

namespace TV\UserBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TV\UserBundle\Entity\Follow;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class FollowController extends Controller
{
    
    /**
    * @Security("has_role('ROLE_USER')")
    */
    public function indexAction()
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        
        $listUsers = $this->getDoctrine()
            ->getManager()
            ->getRepository('TVUserBundle:User')
            ->getFolloweds($user)
        ;
        
        $count = 0;
        
        return $this->render('TVUserBundle:User:my_chefs.html.twig', array(
            'listUsers' => $listUsers,
            'count' => $count,
        ));
    }
    
    /**
    * @Security("has_role('ROLE_USER')")
    */
    public function addAction($id)
    {
        $follow = new Follow();
        
        $em = $this->getDoctrine()->getManager();
        $followed = $em->getRepository('TVUserBundle:User')->find($id);
        
        $follower = $this->container->get('security.token_storage')->getToken()->getUser();
        
        $follow->setFollower($follower);
        $follow->setFollowed($followed);
        
        $em->persist($follow);
        $em->flush();
        
         return $this->redirectToRoute('tv_chef_homepage');
    }
}
