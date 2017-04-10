<?php
namespace TV\ChefBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
class HomeController extends Controller
{
    public function indexAction()
    {
        return $this->render('TVChefBundle:Pages:index.html.twig');
    }
}

