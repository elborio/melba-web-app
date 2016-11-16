<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\RegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }

    /**
     * @Route("/register", name="user_registration")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function registerAction(Request $request) {

        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('registration_success');

        }

        return $this->render(
            'registration/registration.html.twig',
            array('form' => $form->createView())
        );

    }

    /**
     * @Route("/register/failed", name="registration_failed")
     */
    public function registrationFailedAction() {

        $this->addFlash('message', 'registration failed');
        return $this->render('registration/registration_finished.html.twig');
    }

    /**
     * @Route("/register/success", name="registration_success")
     */
    public function registrationSuccessAction() {

        $this->addFlash('message', 'registration succes');
        return $this->redirectToRoute('home');
        //return $this->render('registration/registration_finished.html.twig');
    }
}
