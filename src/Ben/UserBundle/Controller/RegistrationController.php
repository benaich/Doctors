<?php

namespace Ben\UserBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Controller\RegistrationController as BaseController;
use Ben\BlogBundle\Entity\newsletter;

class RegistrationController extends BaseController
{
    public function registerAction()
    {
        $form = $this->container->get('fos_user.registration.form');
        $formHandler = $this->container->get('fos_user.registration.form.handler');
        $confirmationEnabled = $this->container->getParameter('fos_user.registration.confirmation.enabled');

        $process = $formHandler->process($confirmationEnabled);
        if ($process) {
            $user = $form->getData();

            // Add user email to newsletter 
            $em = $this->container->get('doctrine')->getManager();
            $newsletter = new Newsletter;
            $newsletter->setName($user->getUsername());
            $newsletter->setEmail($user->getEmail());
            $newsletter->setStatus(true);
            $em->persist($newsletter);
            $em->flush();
             // send a welcome message
            $sender = $this->container->get('fos_user.user_manager')->findUserByUsername('admin');
            $threadBuilder = $this->container->get('fos_message.composer')->newThread();
            $threadBuilder
                ->addRecipient($user)
                ->setSender($sender)
                ->setSubject('welcome message')
                ->setBody('You have a typo, : mondo instead of mongo. Also for coding standards ...');
            $sender = $this->container->get('fos_message.sender');
            $sender->send($threadBuilder->getMessage());

            /*****************************************************/

            if ($confirmationEnabled) {
                $this->container->get('session')->set('fos_user_send_confirmation_email/email', $user->getEmail());
                $route = 'fos_user_registration_check_email';
            } else {
                $this->authenticateUser($user);
                $route = 'fos_user_registration_confirmed';
            }

            $this->setFlash('fos_user_success', 'registration.flash.user_created');
            $url = $this->container->get('router')->generate($route);

            return new RedirectResponse($url);
        }
        //login variables
        $error = '';
        $lastUsername='';
        $csrfToken = $this->container->get('form.csrf_provider')->generateCsrfToken('authenticate');
        
        
        return $this->renderLogin(array(
            'last_username' => $lastUsername,
            'error'         => $error,
            'csrf_token' => $csrfToken,
            'form' => $form->createView(),
        ));
    }
    
    protected function renderLogin(array $data)
    {
        $template = sprintf('FOSUserBundle:Security:login.html.%s', $this->container->getParameter('fos_user.template.engine'));

        return $this->container->get('templating')->renderResponse($template, $data);
    }
}