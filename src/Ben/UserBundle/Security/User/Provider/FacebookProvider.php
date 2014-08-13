<?php

namespace Ben\UserBundle\Security\User\Provider;

use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Facebook;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use \BaseFacebook;
use \FacebookApiException;

class FacebookProvider implements UserProviderInterface
{
    /**
     * @var \Facebook
     */
    protected $facebook;
    protected $userManager;
    protected $validator;
    protected $container;

    public function __construct(BaseFacebook $facebook, $userManager, $validator, $container)
    {
        $this->facebook = $facebook;

        // Add this to not have the error "the ssl certificate is invalid."
        Facebook::$CURL_OPTS[CURLOPT_SSL_VERIFYPEER] = false;
        Facebook::$CURL_OPTS[CURLOPT_SSL_VERIFYHOST] = 2;

        $this->userManager = $userManager;
        $this->validator = $validator;
        $this->container = $container;
    }

    public function supportsClass($class)
    {
        return $this->userManager->supportsClass($class);
    }

    public function findUserByFbId($fbId)
    {
        return $this->userManager->findUserBy(array('facebookId' => $fbId));
    }

    public function findUserByUsername($username)
    {
        return $this->userManager->findUserBy(array('username' => $username));
    }

    public function connectExistingAccount()
    {

        try {
            $fbdata = $this->facebook->api('/me');
        } catch (FacebookApiException $e) {
            $fbdata = null;
            return false;
        }

        $alreadyExistingAccount = $this->findUserByFbId($fbdata['id']);

        if (!empty($alreadyExistingAccount)) {
            return false;
        }

        if (!empty($fbdata)) {

            $currentUserObj = $this->container->get('security.context')->getToken()->getUser();

            $user = $this->findUserByUsername($currentUserObj->getUsername());

            if (empty($user)) {
                return false;
            }

            $user->setFBData($fbdata);

            if (count($this->validator->validate($user, 'Facebook'))) {
                // TODO: the user was found obviously, but doesnt match our expectations, do something smart
                throw new UsernameNotFoundException('Une erreur est survenue lors de votre connexion...');
            }
            $this->userManager->updateUser($user);

            return true;
        }

        return false;

    }

    public function loadUserByUsername($username)
    {
        $user = $this->findUserByFbId($username);

        try {
            $fbdata = $this->facebook->api('/me');
        } catch (FacebookApiException $e) {
            $fbdata = null;
        }

        if (!empty($fbdata)) {
            if (empty($user)) {
				if (!isset($fbdata['email']) || $fbdata['email']== '') {
				// TODO: the user was found obviously, but doesnt match our expectations, do something smart
				throw new UsernameNotFoundException('Une erreur est survenue lors de votre connexion...');
				}
                $user = $this->userManager->createUser();
                $user->setEnabled(true);
                $user->setPassword('');
            }

            if($user->getUsername() == '' || $user->getUsername() == null)
            {
                $user->setUsername($username . '@facebook.com');
            }

            $user->setFBData($fbdata);

            if (count($this->validator->validate($user, 'Facebook'))) {
                // TODO: the user was found obviously, but doesnt match our expectations, do something smart
                throw new UsernameNotFoundException('Une erreur est survenue lors de votre connexion...');
            }
            $this->userManager->updateUser($user);
        }

        if (empty($user)) {

            // TODO: the user was found obviously, but doesnt match our expectations, do something smart
            throw new UsernameNotFoundException('Une erreur est survenue lors de votre connexion...');

        }

        return $user;
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$this->supportsClass(get_class($user)) || !$user->getFacebookId()) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        return $this->loadUserByUsername($user->getFacebookId());
    }
}