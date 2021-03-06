<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

class LoginController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $user = $this->getUser();
        if ($user) {
            //TODO: make dynamic for user.
            $group = $this->getDoctrine()->getRepository('AppBundle:Group')->find(1);
            if ($group) {
                $user->setGroups(array($group));
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
            }

            $this->addFlash('notice', 'hoi '. $user->getUsername()."test". $user->getGroups()->first()->getName());
        }

        return $this->render('security/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }

    /**
     * @Route("/login", name="login_failure")
     */
    public function loginFailedAction(Request $request)
    {
        throw new BadCredentialsException();
    }

    /**
     * @Route("/test", name="test")
     */
    public function testAction() {
        return new Response("test");
    }
}
