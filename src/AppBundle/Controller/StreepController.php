<?php

namespace AppBundle\Controller;

use AppBundle\Entity\BeerMark;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StreepController extends Controller
{
    /**
     * @param $name
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     * @Route("/streeplijst", name = "streep_index")
     */
    public function indexAction($name)
    {
        /* @var $user \AppBundle\Entity\User */
        $user = $this->getUser();
        $group = $user->getCurrentGroup();

        if (!$group) {
            throw new \Exception("No Group Found");
        }
        $groupName = $group->getName();

        return $this->render('streeplijst.html.twig',
            array(
            'name' => $name,
                'group_name' => $groupName
        ));
    }

    /**
     * @Route("/streeplijst/one", name="streep_one")
     */
    public function streepOneForUserAction() {
        /* @var $user \AppBundle\Entity\User */
        $user = $this->getUser();
        /* @var $group \AppBundle\Entity\Group */
        $group = $user->getCurrentGroup();

        $mark = new BeerMark();
        $mark->setDateAdded(new \DateTime());
        $mark->setUser($user);
        $mark->setGroup($group);
        $em = $this->getDoctrine()->getManager();
        $em->persist($mark);
        $em->flush();

        $this->addFlash('notice', "Marked one beer for ". $user->getUsername());

        return $this->render('streeplijst.html.twig', array());

    }

    public function getStripeStatsAction() {

        $amount = $this->getBeerTotalForCurrentUser();
        $this->get('logger')->info(" amount =". $amount);

        $totalAmount = $this->getBeerTotalForCurrentGroup();
        $thisWeek = $this->getBeerTotalForLastWeek();

        return $this->render('blocks/beer_stats_block.html.twig', array(
            'current_user_amount' => $amount,
            'total_amount' => $totalAmount,
            'this_week' => $thisWeek
        ));
    }


    public function getBeerTotalForCurrentUser() {
        $amount = $this->getDoctrine()->getRepository("AppBundle:BeerMark")->getBeerCountForUser($this->getUser());
        return $amount;

    }
    public function getBeerTotalForCurrentGroup() {
        $amount = $this->getDoctrine()->getRepository("AppBundle:BeerMark")->getBeerCountForGroup($this->getUser()->getCurrentGroup());
        return $amount;

    }

    private function getBeerTotalForLastWeek()
    {
        $amount = $this->getDoctrine()->getRepository("AppBundle:BeerMark")->getBeerCountForGroupLastWeek($this->getUser()->getCurrentGroup());
        return $amount;
    }


}
