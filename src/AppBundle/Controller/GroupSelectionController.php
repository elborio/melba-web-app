<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Group;
use AppBundle\Entity\User;
use AppBundle\Form\GroupSelectorType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Tests\Extension\Core\Type\SubmitTypeTest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

class GroupSelectionController extends Controller
{
    /**
     * @var User
     */
    private $user;

    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }

    /**
     * @Route("/groups", name="group_selection")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showGroupSelectorAction(Request $request)
    {
        $user = $this->getUser();

        if (!$user) {
            throw new BadCredentialsException();
        }

        $groups = $user->getGroups();
        $group = new Group();

        $form = $this->createForm(new GroupSelectorType($groups->getData()));

        return $this->render('testing/group_selection.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/groups/users/{id}", name="users_in_group")
     * @return Response
     */
    public function showUsersInGroup($id)
    {

        $users = $this->getDoctrine()->getRepository('AppBundle:User')->getUsersInGroupWithId($id);

        return $this->render('testing/user_list.html.twig', array('users' => $users));
    }

    /**
     * @Route("/groups/list", name="list_groups_for_user")
     * @return Response
     */
    public function listGroupsForUser()
    {

        $user = $this->getUser();

        if (!$user) {
            throw new UnsupportedUserException();
        }

        //$groups = $this->getDoctrine()->getRepository('AppBundle:Group')->getGroupsForUser($user);
        $groups = $user->getGroups();

        return $this->render('testing/group_list.html.twig', array('groups' => $groups));
    }

    /**
     * @Route("/groups/set/{group}", name="select_group")
     */
    public function setGroupAction($group)
    {

        $user = $this->getUser();
        $groups = $user->getGroups();

        foreach ($groups as $g) {
            if ($g->getId() == $group) {
                $user->setCurrentGroup($group);
                return $this->render('homepage/homepage.html.twig', array());
            }
        }

        return $this->render('error_page.html.twig', array('error' => "An error occured"));
    }

    /**
     * @Route("/groups/create", name="create_group")
     * @param Request $request
     * @return Response
     */
    public function createGroupAction(Request $request) {

        $form = $this->createFormBuilder()
            ->add('name', TextType::class)
        ->add('description', TextType::class)
        ->getForm();

        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()) {

            $inviteKey = base64_encode(random_bytes(20));

            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            $group = new Group();
            $group->setName($data['name']);
            $group->setDateCreated(new \DateTime());
            $group->setInviteKey($inviteKey);
            $group->setIsActive(1);
            $group->addUser($user);
            $group->setDescription($data['description']);

            $em->persist($group);
            $user->addGroup($group);
            $em->flush();

            return new Response("group created with key: ".base64_encode(random_bytes(20)));
        }

        return $this->render('create_group.html.twig', array('form' => $form->createView()));
    }
}
