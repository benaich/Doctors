<?php
namespace Ben\UserBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Model\UserInterface;
use JMS\SecurityExtraBundle\Annotation\Secure;
use FOS\UserBundle\Controller\GroupController as BaseController;

class GroupController extends BaseController
{
    /**
     * Show all groups
     * @Secure(roles="ROLE_MANAGER")
     */
    public function listAction()
    {
        $groups = $this->container->get('fos_user.group_manager')->findGroups();
        $form = $this->container->get('fos_user.group.form');

        return $this->container->get('templating')->renderResponse('FOSUserBundle:Group:list.html.'.$this->getEngine(),
         array('groups' => $groups, 'form' => $form->createview()));
    }

    /**
     * Show one group
     * @Secure(roles="ROLE_MANAGER")
     */
    public function showAction($groupname)
    {
        $group = $this->findGroupBy('name', $groupname);

        return $this->container->get('templating')->renderResponse('FOSUserBundle:Group:show.html.'.$this->getEngine(), array('group' => $group));
    }

    /**
     * Edit one group, show the edit form
     * @Secure(roles="ROLE_MANAGER")
     */
    public function editAction($groupname)
    {
        $group = $this->findGroupBy('name', $groupname);
        $form = $this->container->get('fos_user.group.form');
        $formHandler = $this->container->get('fos_user.group.form.handler');

        $process = $formHandler->process($group);
        if ($process) {
            $this->setFlash('fos_user_success', 'le groupe a été mis à jour avec succeés');
            $url = $this->container->get('router')->generate('fos_user_group_list');

            return new RedirectResponse($url);
        }

        return $this->container->get('templating')->renderResponse('FOSUserBundle:Group:edit.html.'.$this->getEngine(), array(
            'form'      => $form->createview(),
            'groupname'  => $group->getName(),
        ));
    }

    /**
     * Show the new form
     * @Secure(roles="ROLE_MANAGER")
     */
    public function newAction()
    {
        $form = $this->container->get('fos_user.group.form');
        $formHandler = $this->container->get('fos_user.group.form.handler');

        $process = $formHandler->process();
        if ($process) {
            $this->setFlash('fos_user_success', 'le groupe a été ajouté avec succeés');
            $url = $this->container->get('router')->generate('fos_user_group_list');

            return new RedirectResponse($url);
        }

        return $this->container->get('templating')->renderResponse('FOSUserBundle:Group:new.html.'.$this->getEngine(), array(
            'form' => $form->createview(),
        ));
    }

    /**
     * Delete one group
     * @Secure(roles="ROLE_MANAGER")
     */
    public function deleteAction($groupname)
    {
        $group = $this->findGroupBy('name', $groupname);
        $this->container->get('fos_user.group_manager')->deleteGroup($group);
        $this->setFlash('fos_user_success', 'le groupe a été supprimé avec succeés');

        return new RedirectResponse($this->container->get('router')->generate('fos_user_group_list'));
    }

    /**
     * Find a group by a specific property
     *
     * @param string $key   property name
     * @param mixed  $value property value
     *
     * @throws NotFoundException                    if user does not exist
     * @return \FOS\UserBundle\Model\GroupInterface
     */
    protected function findGroupBy($key, $value)
    {
        if (!empty($value)) {
            $group = $this->container->get('fos_user.group_manager')->{'findGroupBy'.ucfirst($key)}($value);
        }

        if (empty($group)) {
            throw new NotFoundHttpException(sprintf('The group with "%s" does not exist for value "%s"', $key, $value));
        }

        return $group;
    }

    protected function getEngine()
    {
        return $this->container->getParameter('fos_user.template.engine');
    }

    /**
     * @param string $action
     * @param string $value
     */
    protected function setFlash($action, $value)
    {
        $this->container->get('session')->getFlashBag()->set($action, $value);
    }
}
