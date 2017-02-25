<?php

namespace AppBundle\Controller;

use GuzzleHttp\Message\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class loginTestController extends Controller
{
    /**
     * @Route ("/test/name")
     * @param $name
     * @return \Symfony\Component\HttpFoundation\Response
     *
     */
    public function testAction($name)
    {
        return new Response(json_encode($name));
    }
}
