<?php

namespace AppBundle\Controller\API;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }

    /**
     * @Route ("/api/register_phone")
     */
    public function registerPhoneAction() {

        return new Response("Hoi");
    }

    /**
     * @Route ("/api")
     */
    public function mainAction() {

        /*$response = new Response();
        $response->headers->set('Content-Type', 'text/json');*/

        $this->addFlash("notice", "Authenticated");


        return $this->render('API/default.html.twig',array());
    }

    /**
     * @Route ("/api/users")
     */

    public function getUsersAction() {

        $user = $this->getDoctrine()->getRepository('AppBundle:User')->findAll();

        return $this->render(':API:user_list.html.twig', array('users' => $user));

    }


}
