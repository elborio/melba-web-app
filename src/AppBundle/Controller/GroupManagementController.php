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

    public function listUsersAction() {

        $users = $this->getDoctrine()->getRepository("AppBundle:User")->getUsersInGroup($this->getUser()->getCurrentGroup());


        return $this->render('user_table.html.twig', array('table_rows' => $users));
    }
}
