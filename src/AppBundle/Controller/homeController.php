<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    /**
     * @param $name
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/home", name="home")
     */
    public function indexAction($name)
    {
        $group = $this->getUser()->getCurrentGroup();
        if (!isset($group)) {
            return $this->redirectToRoute('list_groups_for_user');
        }
        return $this->render('homepage/homepage.html.twig', array('name' => $name));
    }
}
