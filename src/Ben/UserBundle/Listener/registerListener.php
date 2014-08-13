<?php
namespace Ben\UserBundle\Listener;
 
use FOS\UserBundle\Event\FilterUserResponseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Ben\BlogBundle\Entity\newsletter;

/**
 * Listener responsible to change the redirection at the end of the password resetting
 */
class registerListener implements EventSubscriberInterface
{
    protected $context;
    protected $em;
 
    public function __construct(SecurityContext $context, EntityManager $em)
    {
        $this->context = $context;
        $this->em = $em;
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            FOSUserEvents::RESETTING_RESET_SUCCESS => 'onRegistrationCompleted',
        );
    }

    public function onRegistrationCompleted(FilterUserResponseEvent $event)
    {
        $user = $event->getAuthenticationToken()->getUser();
        $entity= new newsletter();
        $entity->setName($user->getUsername());
        $entity->setEmail($user->getEmail());
        $entity->setStatus(true);
        $this->em->persist($entity);
        $this->em->flush($entity);
    }
}