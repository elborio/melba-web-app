<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Group;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ModuleController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }

    /**
     *
     */
    public function getAvailableModulesAction(Group $group) {

    }

    public function renderModulesForGroupAction($group) {


    }
}
