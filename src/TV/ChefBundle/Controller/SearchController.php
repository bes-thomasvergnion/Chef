<?php

namespace TV\ChefBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
        $user = $request->getClientIp();
        
        if( !defined($page)){
            $search = new Search();
            $search->setIp($user);
            $form = $this->createForm(SearchType::class, $search);
            
            if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($search);           
                $em->flush();
            }
        }

        if ($page >= 1){
            $search = $this->getDoctrine()
                ->getManager()
                ->getRepository('TVChefBundle:Search')
                ->getSearch($user)
            ;
            $form = $this->createForm(SearchType::class, $search);
        }

        $nbPerPage = 18;
        $count = 0;

        $listRecipes = $this->getDoctrine()
            ->getManager()
            ->getRepository('TVChefBundle:Recipe')
            ->getRecipesWithSearch($search, $page, $nbPerPage)
        ;
        $nbPages = ceil(count($listRecipes)/$nbPerPage);
        
        return $this->render('TVChefBundle:Pages:search-result.html.twig', array(
            'listRecipes' => $listRecipes,
            'nbPerPage' => $nbPerPage,
            'nbPages' => $nbPages,
            'page' => $page,
            'count' => $count,
            'search' => $search
        ));
    }
    
    public function autocompleteAction(Request $request)
    {
        if($request->isXmlHttpRequest())
        {
            $term = $request->request->get('motcle');
             
            $array= $this->getDoctrine()
                ->getManager()
                ->getRepository('TVChefBundle:Recipe')
                ->listeRecipes($term);
             
            $response = new Response(json_encode($array));
             
            $response -> headers -> set('Content-Type', 'application/json');
            return $response;
        }
    }
}
