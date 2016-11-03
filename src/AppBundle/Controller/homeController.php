<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class homeController extends Controller
{
    /**
     * @param $name
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/home", name="home")
     */
    public function indexAction($name)
    {
        return $this->render('homepage/homepage.html.twig', array('name' => $name));
    }
}
