<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class GroupManagementController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }

    /**
     * @Route("/group/manage", name="group_management")
     */
    public function showGroupManageAction() {



        return $this->render('manage.html.twig', array());
    }
}
