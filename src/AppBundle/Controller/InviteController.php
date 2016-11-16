<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Group;
use AppBundle\Entity\GroupInvite;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Mailgun\Mailgun;

class InviteController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }

    /**
     * @param Request $request
     * @Route("/invitation/confirm/", name="confirm_invite")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function confirmInviteAction(Request $request) {

        $email = $request->get('email');
        $key = $request->get('invite_key');

        $invite = $this->getDoctrine()->getRepository(GroupInvite::class)->findInviteByEmailAndCode($email, $key);

        /**  @var $user User */
        $user = $this->getUser();

        if (!$user) {
            $this->addFlash('notice', "No User Found");
            return $this->render('confirm_invite.html.twig', array());
        }

        if ($invite != null) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($invite);

            $this->get('logger')->addInfo("is in group: " .$user->isInGroup($invite->getGroup()));
            if (!$user->isInGroup($invite->getGroup())) {
                $groups = $user->getGroups();
                $groups->add($invite->getGroup());
                $user->setGroups($groups);
                $user->setCurrentGroup($invite->getGroup());
                $em->merge($user);

            } else {
                //already added/
            }

            $em->flush();

            $this->addFlash('notice', "Added to group ".$invite->getGroup()->getName());
        } else {
            //no invite found.
            $this->addFlash('notice', "No invite found");

        }

        return $this->render('confirm_invite.html.twig', array());
    }

    public function sendInviteAction(Request $request) {
        /* @var $form Form */
        $form = $this->createFormBuilder()
            ->add('email', EmailType::class)
            ->getForm();

        $form->handleRequest($request);

        $this->get('logger')->addInfo($request->getContent());

        if ($form->isValid() && $form->isSubmitted()) {
            $this->get('logger')->addInfo($form->getData()['email']);
            $group = $this->getUser()->getCurrentGroup();
            $invite = $this->generateInviteAction($form->getData()['email'], $group);
            $this->sendInvite($invite);
        }

        return $this->render('invite_module.html.twig', array('form' => $form->createView()));
    }

    /**
     * @param $email String
     * @param $group Group
     * @return GroupInvite
     */
    public function generateInviteAction($email, $group) {
        /* @var $invite \AppBundle\Entity\GroupInvite */
        $invite = new GroupInvite();
        //$invite->setGroup(new Group());
        $invite->setGroup($group);
        $invite->setEmail($email);
        $datetime = new \DateTime("+1 week");
        $invite->setExpiration($datetime);
        $invite->setInviteKey(base64_encode(random_bytes(24)));
        $em = $this->getDoctrine()->getManager();
        $em->persist($invite);
        $em->flush();

        return $invite;
    }

    /**
     * @param $invite GroupInvite
     * @return \stdClass
     * @throws \Mailgun\Messages\Exceptions\MissingRequiredMIMEParameters
     */
    public function sendInvite($invite) {

        $mailGun = new Mailgun("key-0038ade1e4b1b3d6a0a096bdb51ad481");
        $result = $mailGun->sendMessage("sandbox5fb2e9dd29d44ecbbec26168e744ce4d.mailgun.org", array(
            'from' => "no-reply@test.nl",
            'to'    => $invite->getEmail(),
            'subject' => "group invite for group ".$invite->getGroup()->getName(),
            'text'  => "Hello, you have been invited to join our house management group, please click on the link to confirm the invite".
                " :D http://melba-app".$this->generateUrl("confirm_invite", array("invite_key" => $invite->getInviteKey(), 'email' => $invite->getEmail()), false)
        ));

        /*$message = \Swift_Message::newInstance()
            ->setSubject("group invite for group ".$invite->getGroup()->getName())
            ->setFrom("elborio@gmail.com")
            ->setTo($invite->getEmail())
            ->setBody("Hello, you have been invited to join our house managment group, please click on the link to confirm the invite".
                " :D ".$this->generateUrl("confirm_invite", array("invite_key" => $invite->getInviteKey()), true));

        $this->get('mailer')->send($message);*/

        return $result;
    }
}
