<?php

namespace TV\ChefBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TV\ChefBundle\Entity\Filter;
use TV\ChefBundle\Form\FilterType;

class FilterController extends Controller
{
    public function indexAction(Request $request)
    {
        $filter = new Filter();
        if (null !== $request->query->get('category')){
            $category = $this->getDoctrine()->getManager()->getRepository('TVChefBundle:Category')->findOneBy(['name'=>$request->query->get('category')]);
            $filter->setCategory($category);
        }
        
        if (null !== $request->query->get('type')){
            $type = $this->getDoctrine()->getManager()->getRepository('TVChefBundle:Type')->findOneBy(['name'=>$request->query->get('type')]);
            $filter->setType($type);
        }
        
        if (null !== $request->query->get('locality')){
            $locality = $this->getDoctrine()->getManager()->getRepository('TVChefBundle:Locality')->findOneBy(['name'=>$request->query->get('locality')]);
            $filter->setLocality($locality);
        }
            
        $form = $this->get('form.factory')->create(FilterType::class, $filter, ['method'=>'GET','action'=>$this->generateUrl('tv_chef_filter_select',[], \Symfony\Component\Routing\Router::ABSOLUTE_URL),'attr'=>['data-action'=>$this->generateUrl('tv_chef_filter_select',[], \Symfony\Component\Routing\Router::ABSOLUTE_URL)]]);
       
        return $this->render('TVChefBundle:Pages:filters.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
    public function selectAction(Request $request, $page)
    {       
        $filter = new Filter();
        $form = $this->createForm(FilterType::class, $filter,['action'=>$this->generateUrl('tv_chef_filter_select')]);
        $nbPerPage = 18;
        $count = 0;
               
        if ( $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($filter);
            $em->flush();
        }
        
        $listRecipes = $this->getDoctrine()
            ->getManager()
            ->getRepository('TVChefBundle:Recipe')
            ->getRecipesWithFilters($filter, $request->query->get('page') !== null ? $request->query->get('page') : 1, $nbPerPage)
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
