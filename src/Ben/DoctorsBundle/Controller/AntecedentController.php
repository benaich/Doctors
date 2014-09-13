<?php

namespace Ben\DoctorsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;

use Ben\DoctorsBundle\Entity\Antecedent;
use Ben\DoctorsBundle\Form\AntecedentType;
use Ben\DoctorsBundle\Entity\Person;

/**
 * Antecedent controller.
 *
 */
class AntecedentController extends Controller
{

    /**
     * Lists all Antecedent entities.
     * @Secure(roles="ROLE_USER")
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BenDoctorsBundle:Antecedent')->findAll();

        return $this->render('BenDoctorsBundle:Antecedent:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Antecedent entity.
     * @Secure(roles="ROLE_USER")
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Antecedent();
        $form = $this->createForm(new AntecedentType(), $entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('person_show', array('id' => $entity->getPerson()->getId())));
        }

        return $this->render('BenDoctorsBundle:Antecedent:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new Antecedent entity.
     * @Secure(roles="ROLE_USER")
     *
     */
    public function newAction(Person $person)
    {
        $entity = new Antecedent();
        $entity->setPerson($person);
        $form = $this->createForm(new AntecedentType(), $entity);

        return $this->render('BenDoctorsBundle:Antecedent:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Antecedent entity.
     * @Secure(roles="ROLE_USER")
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BenDoctorsBundle:Antecedent')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Antecedent entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BenDoctorsBundle:Antecedent:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Antecedent entity.
     * @Secure(roles="ROLE_USER")
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BenDoctorsBundle:Antecedent')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Antecedent entity.');
        }

        $editForm = $this->createForm(new AntecedentType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BenDoctorsBundle:Antecedent:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Edits an existing Antecedent entity.
     * @Secure(roles="ROLE_USER")
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BenDoctorsBundle:Antecedent')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Antecedent entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new AntecedentType(), $entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('antecedent_edit', array('id' => $id)));
        }

        return $this->render('BenDoctorsBundle:Antecedent:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Antecedent entity.
     * @Secure(roles="ROLE_ADMIN")
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BenDoctorsBundle:Antecedent')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Antecedent entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('antecedent'));
    }

    /**
     * Creates a form to delete a Antecedent entity by id.
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
