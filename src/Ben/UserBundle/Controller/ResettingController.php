<?php

namespace Ben\UserBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RedirectResponse;

use FOS\UserBundle\Controller\ResettingController as BaseController;

class ResettingController extends BaseController {

    /**
     * Request reset user password: submit form and send email
     */
    public function sendEmailAction() {
        $username = $this->container->get('request')->request->get('username');

        /** @var $user UserInterface */
        $user = $this->container->get('fos_user.user_manager')->findUserByUsernameOrEmail($username);

        if (null === $user) {
            return $this->container->get('templating')->renderResponse('FOSUserBundle:Resetting:request.html.' . $this->getEngine(), array('invalid_username' => $username));
        }

        if ($user->isPasswordRequestNonExpired($this->container->getParameter('fos_user.resetting.token_ttl'))) {
            $flash = "Un nouveau mot de passe a déjà été demandé pour cet utilisateur dans les dernières 24 heures.";
            $this->setFlash('error', $flash);
            return new RedirectResponse($this->container->get('router')->generate('home'));
        }

        if (null === $user->getConfirmationToken()) {
            /** @var $tokenGenerator \FOS\UserBundle\Util\TokenGeneratorInterface */
            $tokenGenerator = $this->container->get('fos_user.util.token_generator');
            $user->setConfirmationToken($tokenGenerator->generateToken());
        }

        $this->container->get('session')->set(static::SESSION_EMAIL, $this->getObfuscatedEmail($user));
        $this->container->get('fos_user.mailer')->sendResettingEmailMessage($user);
        $user->setPasswordRequestedAt(new \DateTime());
        $this->container->get('fos_user.user_manager')->updateUser($user);

        return new RedirectResponse($this->container->get('router')->generate('fos_user_resetting_check_email'));
    }

    /**
     * Tell the user to check his email provider
     */
    public function checkEmailAction() {
        $session = $this->container->get('session');
        $email = $session->get(static::SESSION_EMAIL);
        $session->remove(static::SESSION_EMAIL);

        if (empty($email)) {
            // the user does not come from the sendEmail action
            return new RedirectResponse($this->container->get('router')->generate('fos_user_resetting_request'));
        }
        if (false !== $pos = strpos($email, '@')) {
            $email = '...' . substr($email, $pos);
        }
        $flash = "Un e-mail a été envoyé à l'adresse " . $email . ". Il contient un lien sur lequel il vous faudra cliquer afin de réinitialiser votre mot de passe.";
        $this->setFlash('success', $flash);
        return new RedirectResponse($this->container->get('router')->generate('home'));
    }

}
