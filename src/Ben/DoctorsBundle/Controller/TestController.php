<?php

namespace Ben\DoctorsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Httpfoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;

use Ben\DoctorsBundle\Entity\Test;
use Ben\DoctorsBundle\Form\TestType;
use Ben\DoctorsBundle\Entity\Consultation;

use Ben\DoctorsBundle\Pagination\Paginator;

/**
 * Test controller.
 *
 */
class TestController extends Controller
{

    /**
     * Lists all Test entities.
     * @Secure(roles="ROLE_USER")
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $doctors = $em->getRepository('BenUserBundle:User')->findAll();
        $entitiesLength = $em->getRepository('BenDoctorsBundle:Test')->counter();

        return $this->render('BenDoctorsBundle:Test:index.html.twig', array(
            'doctors' => $doctors,
            'entitiesLength' => $entitiesLength));
    }

    /**
     * Tests list using ajax
     * @Secure(roles="ROLE_USER")
     */
    public function ajaxListAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $searchParam = $request->get('searchParam');
        $entities = $em->getRepository('BenDoctorsBundle:Test')->search($searchParam);
        $pagination = (new Paginator())->setItems(count($entities), $searchParam['perPage'])->setPage($searchParam['page'])->toArray();
        return $this->render('BenDoctorsBundle:Test:ajax_list.html.twig', array(
                    'entities' => $entities,
                    'pagination' => $pagination,
                    ));
    }
    /**
     * Creates a new Test entity.
     * @Secure(roles="ROLE_USER")
     *
     */
    public function createAction(Request $request, $type)
    {
        $entity = new Test();
        $form = $this->createForm(new TestType($type), $entity);
        $form->handleRequest($request);
        if($type) $entity->setType(Test::$GENERAL);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('info', "L'examen a été ajouté avec succès.");
            return $this->redirect($this->generateUrl('consultation_show', array('id' => $entity->getConsultation()->getId())));
        }

        $this->get('session')->getFlashBag()->add('danger', "Il y a des erreurs dans le formulaire soumis !");
        return $this->render('BenDoctorsBundle:Test:new.html.twig', array(
            'entity' => $entity,
            'type' => $type,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new Test entity.
     * @Secure(roles="ROLE_USER")
     *
     */
    public function newAction(Consultation $consultation, $type)
    {
        $entity = new Test();
        $entity->setConsultation($consultation);
        $form   = $this->createForm(new TestType($type), $entity);

        return $this->render('BenDoctorsBundle:Test:new.html.twig', array(
            'entity' => $entity,
            'type' => $type,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Test entity.
     * @Secure(roles="ROLE_USER")
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BenDoctorsBundle:Test')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Test entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        return $this->render('BenDoctorsBundle:Test:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Test entity.
     * @Secure(roles="ROLE_USER")
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BenDoctorsBundle:Test')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Test entity.');
        }
        $type = ($entity->getType()===Test::$GENERAL);
        $editForm = $this->createForm(new TestType($type), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BenDoctorsBundle:Test:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Edits an existing Test entity.
     * @Secure(roles="ROLE_USER")
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BenDoctorsBundle:Test')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Test entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $type = ($entity->getType()===Test::$GENERAL);
        $editForm = $this->createForm(new TestType($type), $entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('info', "L'examen a été mis à jour avec succès.");
            return $this->redirect($this->generateUrl('test_edit', array('id' => $id)));
        }

        $this->get('session')->getFlashBag()->add('danger', "Il y a des erreurs dans le formulaire soumis !");
        return $this->render('BenDoctorsBundle:Test:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Test entity.
     * @Secure(roles="ROLE_USER")
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);
        $consultation_id = 0;
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BenDoctorsBundle:Test')->find($id);
            if (!$entity) 
                throw $this->createNotFoundException('Unable to find Consultation entity.');

            $consultation = $entity->getConsultation();
            $currentUser = $this->get('security.context')->getToken()->getUser();
            if ($currentUser != $consultation->getUser() && !$this->get('security.context')->isGranted('ROLE_ADMIN'))
                $this->get('session')->getFlashBag()->add('danger', "Unauthorized access.");
            else{
                $em->remove($entity);
                $em->flush();
                $this->get('session')->getFlashBag()->add('info', "Action effectué avec succès !");
            }
        }

        return $this->redirect($this->generateUrl('consultation_show', array('id' => $consultation->getId())));
    }

    /**
     * Creates a form to delete a Test entity by id.
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
        $entities = $em->getRepository('BenDoctorsBundle:Test')->search(array('ids'=>$ids));
        foreach( $entities as $entity) $em->remove($entity);
        $em->flush();

        return new Response('1');
    }
}
