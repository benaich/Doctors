<?php

namespace Ben\UserBundle\Security\User\Provider;
 
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use \TwitterOAuth;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\Validator\Validator;  

class TwitterUserProvider implements UserProviderInterface
{
    /** 
     * @var \Twitter
     */
    protected $twitter_oauth;
    protected $userManager;
    protected $validator;
    protected $session;

    public function __construct(TwitterOAuth $twitter_oauth, UserManagerInterface  $userManager,Validator $validator, Session $session)
    {   
        $this->twitter_oauth = $twitter_oauth;
        $this->userManager = $userManager;
        $this->validator = $validator;
        $this->session = $session;
        $this->twitter_oauth->host = 'https://api.twitter.com/1.1/';
    }   

    public function supportsClass($class)
    {   
        return $this->userManager->supportsClass($class);
    }   

    public function findUserByTwitterId($twitterID)
    {   
//        return $this->userManager->findUserBy(array('twitterID' => $twitterID));
        return $this->userManager->findUserBy(array('twitter_username' => $twitterID));
    }   

    public function loadUserByUsername($username)
    {
        $user = $this->findUserByTwitterId($username);

        if (!empty($user)) {
            return $user;
        }

        $this->twitter_oauth->setOAuthToken($this->session->get('access_token'), $this->session->get('access_token_secret'));

        try {
            $info = $this->twitter_oauth->get('account/verify_credentials');
        } catch (Exception $e) {
            $info = null;
        }

        if (!empty($info)) {
            if (empty($user)) {
                $user = $this->userManager->createUser();
                $user->setEnabled(true);
                $user->setPassword('');
            }
            $user->setTwitterData($info);
            $this->userManager->updateUser($user);
        }

        if (empty($user)) {
            throw new UsernameNotFoundException('The user is not authenticated on twitter');
        }

        return $user;
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$this->supportsClass(get_class($user)) || !$user->getTwitterID()) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        return $this->loadUserByUsername($user->getTwitterID());
    }
}