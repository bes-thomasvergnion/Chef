<?php
namespace TV\ChefBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
class HomeController extends Controller
{
    public function indexAction()
    {
        $count = 0;
        $listRecipesLocal = $this->getDoctrine()
            ->getManager()
            ->getRepository('TVChefBundle:Recipe')
            ->getRecipesLocal()
        ;
        
        $listRecipesVegan = $this->getDoctrine()
            ->getManager()
            ->getRepository('TVChefBundle:Recipe')
            ->getRecipesVegan()
        ;
        
        $listRecipesGluten = $this->getDoctrine()
            ->getManager()
            ->getRepository('TVChefBundle:Recipe')
            ->getRecipesGluten()
        ;
        
        return $this->render('TVChefBundle:Pages:index.html.twig',array(
            'listRecipesLocal' => $listRecipesLocal,
            'listRecipesVegan' => $listRecipesVegan,
            'listRecipesGluten' => $listRecipesGluten,
            'count' => $count
        ));
    }
}

