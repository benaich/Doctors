<?php

namespace Ben\DoctorsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entitiesLength = $em->getRepository('BenDoctorsBundle:Test')->counter();

        return $this->render('BenDoctorsBundle:Test:index.html.twig', array(
            'entitiesLength' => $entitiesLength));
    }

    /**
     * Tests list using ajax
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
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Test();
        $form = $this->createForm(new TestType(), $entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            foreach ($entity->getMetadata() as $item) {
                $em->persist($item);
            }
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('test_show', array('id' => $entity->getId())));
        }

        return $this->render('BenDoctorsBundle:Test:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new Test entity.
     *
     */
    public function newAction(Consultation $consultation)
    {
        $entity = new Test();
        $entity->setConsultation($consultation);
        $form   = $this->createForm(new TestType(), $entity);

        return $this->render('BenDoctorsBundle:Test:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Test entity.
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
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BenDoctorsBundle:Test')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Test entity.');
        }

        $editForm = $this->createForm(new TestType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BenDoctorsBundle:Test:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Edits an existing Test entity.
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
        $editForm = $this->createForm(new TestType(), $entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('test_edit', array('id' => $id)));
        }

        return $this->render('BenDoctorsBundle:Test:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Test entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BenDoctorsBundle:Test')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Test entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('test'));
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
}
