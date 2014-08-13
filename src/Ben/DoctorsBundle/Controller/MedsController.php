<?php

namespace Ben\DoctorsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Ben\DoctorsBundle\Entity\Meds;
use Ben\DoctorsBundle\Form\MedsType;

/**
 * Meds controller.
 *
 */
class MedsController extends Controller
{

    /**
     * Lists all Meds entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BenDoctorsBundle:Meds')->findAll();

        return $this->render('BenDoctorsBundle:Meds:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Meds entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Meds();
        $form = $this->createForm(new MedsType(), $entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('meds_show', array('id' => $entity->getId())));
        }

        return $this->render('BenDoctorsBundle:Meds:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new Meds entity.
     *
     */
    public function newAction()
    {
        $entity = new Meds();
        $form = $this->createForm(new MedsType(), $entity);

        return $this->render('BenDoctorsBundle:Meds:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Meds entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BenDoctorsBundle:Meds')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Meds entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BenDoctorsBundle:Meds:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Meds entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BenDoctorsBundle:Meds')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Meds entity.');
        }

        $editForm = $this->createForm(new MedsType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BenDoctorsBundle:Meds:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Edits an existing Meds entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BenDoctorsBundle:Meds')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Meds entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new MedsType(), $entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('meds_edit', array('id' => $id)));
        }

        return $this->render('BenDoctorsBundle:Meds:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Meds entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BenDoctorsBundle:Meds')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Meds entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('meds'));
    }

    /**
     * Creates a form to delete a Meds entity by id.
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
}
