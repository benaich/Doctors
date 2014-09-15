<?php

namespace Ben\DoctorsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Httpfoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;

use Ben\DoctorsBundle\Entity\Consultation;
use Ben\DoctorsBundle\Form\ConsultationType;
use Ben\DoctorsBundle\Entity\Person;
use Ben\DoctorsBundle\Pagination\Paginator;

/**
 * Consultation controller.
 *
 */
class ConsultationController extends Controller
{

    /**
     * Lists all Person entities.
     * @Secure(roles="ROLE_USER")
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $doctors = $em->getRepository('BenUserBundle:User')->findAll();
        $entitiesLength = $em->getRepository('BenDoctorsBundle:Consultation')->counter();

        return $this->render('BenDoctorsBundle:Consultation:index.html.twig', array(
            'doctors' => $doctors,
            'entitiesLength' => $entitiesLength));
    }

    /**
     * Consultations list using ajax
     * @Secure(roles="ROLE_USER")     
     */
    public function ajaxListAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $searchParam = $request->get('searchParam');
        $entities = $em->getRepository('BenDoctorsBundle:Consultation')->search($searchParam);
        $pagination = (new Paginator())->setItems(count($entities), $searchParam['perPage'])->setPage($searchParam['page'])->toArray();
        return $this->render('BenDoctorsBundle:Consultation:ajax_list.html.twig', array(
                    'entities' => $entities,
                    'pagination' => $pagination,
                    ));
    }

    /**
     * Creates a new Consultation entity.
     * @Secure(roles="ROLE_USER")
     *
     */
    public function createAction(Request $request, $type)
    {
        $entity = new Consultation();
        $form = $this->createForm(new ConsultationType($type), $entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $currentUser = $this->container->get('security.context')->getToken()->getUser();
            $entity->setUser($currentUser);
            $em = $this->getDoctrine()->getManager();
            foreach ($entity->getConsultationmeds() as $item) {
                $item->getMeds()->minusCount($item->getCount());
            }
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('info', "La consultation a été enregistré avec succès.");
            return $this->redirect($this->generateUrl('consultation_show', array('id' => $entity->getId())));
        }

        return $this->render('BenDoctorsBundle:Consultation:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new Consultation entity.
     * @Secure(roles="ROLE_USER")
     *
     */
    public function newAction(Person $person, $type)
    {
        $entity = new Consultation();
        if($type) $entity->setType(Consultation::$SPECIAL);
        $entity->setPerson($person);
        $form   = $this->createForm(new ConsultationType($entity->getType()), $entity);

        return $this->render('BenDoctorsBundle:Consultation:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Consultation entity.
     * @Secure(roles="ROLE_USER")
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BenDoctorsBundle:Consultation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Consultation entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BenDoctorsBundle:Consultation:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Consultation entity.
     * @Secure(roles="ROLE_USER")
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BenDoctorsBundle:Consultation')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Consultation entity.');
        }

        $editForm = $this->createForm(new ConsultationType($entity->getType()), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BenDoctorsBundle:Consultation:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Edits an existing Consultation entity.
     * @Secure(roles="ROLE_USER")
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BenDoctorsBundle:Consultation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Consultation entity.');
        }
        $originalMeds = new \Doctrine\Common\Collections\ArrayCollection();
        foreach ($entity->getConsultationmeds() as $item) {
            $originalMeds->add($item);
        }

        $editForm = $this->createForm(new ConsultationType($entity->getType()), $entity);
        $deleteForm = $this->createDeleteForm($id);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            foreach ($originalMeds as $item) {
                if (false === $entity->getConsultationmeds()->contains($item)) {
                    $em->remove($item);
                }
            }
            foreach ($entity->getConsultationmeds() as $item) {
                $item->getMeds()->minusCount($item->getCount());
            }

            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('info', "La consultation a été enregistré avec succès.");
            return $this->redirect($this->generateUrl('consultation_edit', array('id' => $id)));
        }

        $this->get('session')->getFlashBag()->add('danger', "Il y a des erreurs dans le formulaire soumis !");
        return $this->render('BenDoctorsBundle:Consultation:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Consultation entity.
     * @Secure(roles="ROLE_USER")
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BenDoctorsBundle:Consultation')->find($id);
            if (!$entity) 
                throw $this->createNotFoundException('Unable to find Consultation entity.');

            $currentUser = $this->get('security.context')->getToken()->getUser();
            if ($currentUser != $entity->getUser() && !$this->get('security.context')->isGranted('ROLE_ADMIN'))
                $this->get('session')->getFlashBag()->add('danger', "Unauthorized access.");
            else{
                $em->remove($entity);
                $em->flush();
                $this->get('session')->getFlashBag()->add('info', "Action effectué avec succès !");
            }
        }
        return $this->redirect($this->generateUrl('consultation'));
    }

    /**
     * Creates a form to delete a Consultation entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    
    /**
     * Deletes multiple entities
     * @Secure(roles="ROLE_ADMIN")
     */
    public function removeAction(Request $request)
    {
        $ids = $request->get('entities');
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('BenDoctorsBundle:Consultation')->search(array('ids'=>$ids));
        foreach( $entities as $entity) $em->remove($entity);
        $em->flush();

        return new Response('1');
    }
}
