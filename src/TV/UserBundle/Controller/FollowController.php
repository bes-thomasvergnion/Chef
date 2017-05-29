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
        
        $listfollowDb = $this->getDoctrine()
            ->getManager()
            ->getRepository('TVUserBundle:Follow')
            ->findAll()
        ;
        
        $verified = false;
        
        foreach($listfollowDb as $followDb){
            $followerDb = $followDb->getFollower();
            $followedDb = $followDb->getFollowed();
            
            if($followerDb == $follower && $followedDb == $followed){
                $verified = true;
            }
        }
        
        if ($verified == false){
            $em->persist($follow);
            $em->flush();
        }
        
        return $this->redirectToRoute('tv_user_follow_index');
    }
    
    /**
    * @Security("has_role('ROLE_USER')")
    */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $followed = $em->getRepository('TVUserBundle:User')->find($id);
        
        $follower = $this->container->get('security.token_storage')->getToken()->getUser();
        
        $follow = $this->getDoctrine()
            ->getManager()
            ->getRepository('TVUserBundle:Follow')
            ->getFollow($followed, $follower)
        ;
        
//        dump($follow);
//        die();
        
        $em->remove($follow);
        $em->flush();
        return $this->redirectToRoute('tv_user_follow_index');
    }
}
