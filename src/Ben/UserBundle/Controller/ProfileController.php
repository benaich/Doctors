<?php
namespace Ben\UserBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Controller\ProfileController as BaseController;

class ProfileController extends BaseController
{
    public function editAction()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $form = $this->container->get('fos_user.profile.form');
        $formHandler = $this->container->get('fos_user.profile.form.handler');
        
        $passwordform = $this->container->get('fos_user.change_password.form');

        $process = $formHandler->process($user);
        if ($process) {
            $this->setFlash('fos_user_success', 'profile.flash.updated');
            return new RedirectResponse($this->container->get('router')->generate('home'));
        }
        
        // newsletter
        // $em = $this->container->get('doctrine')->getManager();
        // $newsletter = $em->getRepository('BenBlogBundle:newsletter')->findOneByEmail($user->getEmail());

        return $this->container->get('templating')->renderResponse(
            'FOSUserBundle:Profile:edit.html.'.$this->container->getParameter('fos_user.template.engine'),
            array('form' => $form->createView(),
                //'newsletter' => $newsletter,
                'passwordform' => $passwordform->createView())
        );
    }
}
