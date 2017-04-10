<?php

namespace TV\ChefBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TV\ChefBundle\Entity\Search;
use TV\ChefBundle\Form\SearchType;

class FilterController extends Controller
{
    public function indexAction()
    {
        $form = $this->get('form.factory')->create(SearchType::class, null, ['action'=>$this->generateUrl('tv_chef_filter_select',[], \Symfony\Component\Routing\Router::ABSOLUTE_URL)]);
        return $this->render('TVChefBundle:Pages:filters.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
    public function selectAction(Request $request, $page)
    {
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);
        $nbPerPage = 5;
        $count = 0;
       
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($search);
            $em->flush();
        }
        $listRecipes = $this->getDoctrine()
            ->getManager()
            ->getRepository('TVChefBundle:Recipe')
            ->getRecipesWithFilters($search, $page, $nbPerPage)
        ;
        $nbPages = ceil(count($listRecipes)/$nbPerPage);
        
        return $this->render('TVChefBundle:Recipe:list.html.twig', array(
            'listRecipes' => $listRecipes,
            'nbPerPage' => $nbPerPage,
            'nbPages' => $nbPages,
            'page' => $page,
            'count' => $count
        ));
    }
}
