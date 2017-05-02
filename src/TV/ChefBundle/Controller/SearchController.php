<?php

namespace TV\ChefBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TV\ChefBundle\Entity\Search;
use TV\ChefBundle\Form\SearchType;

class SearchController extends Controller
{
    public function indexAction(Request $request)
    {
            
        $form = $this->get('form.factory')->create(SearchType::class, ['action'=>$this->generateUrl('tv_chef_search_select',[], \Symfony\Component\Routing\Router::ABSOLUTE_URL)]);
       
        return $this->render('TVChefBundle:Pages:search-bar.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
    public function selectAction(Request $request, $page)
    {
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);
        $nbPerPage = 6;
        $count = 0;
       
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($search);
            $em->flush();
        }
        $listRecipes = $this->getDoctrine()
            ->getManager()
            ->getRepository('TVChefBundle:Recipe')
            ->getRecipesWithSearch($search, $page, $nbPerPage)
        ;
        $nbPages = ceil(count($listRecipes)/$nbPerPage);
        
        return $this->render('TVChefBundle:Recipe:search-result.html.twig', array(
            'listRecipes' => $listRecipes,
            'nbPerPage' => $nbPerPage,
            'nbPages' => $nbPages,
            'page' => $page,
            'count' => $count
        ));
    }
}
