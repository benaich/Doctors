<?php

namespace Ben\DoctorsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Httpfoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;

use Ben\DoctorsBundle\Entity\Meds;
use Ben\DoctorsBundle\Form\MedsType;
use Ben\DoctorsBundle\Pagination\Paginator;

/**
 * Meds controller.
 *
 */
class MedsController extends Controller
{

    /**
     * Lists all Meds entities.
     * @Secure(roles="ROLE_MANAGER")
     *
     */
    public function indexAction()
    {
        // var_dump($this);die;
        $em = $this->getDoctrine()->getManager();
        $entitiesLength = $em->getRepository('BenDoctorsBundle:Meds')->counter();

        return $this->render('BenDoctorsBundle:Meds:index.html.twig', array(
            'entitiesLength' => $entitiesLength));
    }

    /**
     * persons list using ajax
     * @Secure(roles="ROLE_MANAGER")
     */
    public function ajaxListAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $searchParam = $request->get('searchParam');
        $entities = $em->getRepository('BenDoctorsBundle:Meds')->search($searchParam);
        $pagination = (new Paginator())->setItems(count($entities), $searchParam['perPage'])->setPage($searchParam['page'])->toArray();
        return $this->render('BenDoctorsBundle:Meds:ajax_list.html.twig', array(
                    'entities' => $entities,
                    'pagination' => $pagination,
                    ));
    }

    /**
     * Creates a new Meds entity.
     * @Secure(roles="ROLE_MANAGER")
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
     * @Secure(roles="ROLE_MANAGER")
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
     * @Secure(roles="ROLE_MANAGER")
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
     * @Secure(roles="ROLE_MANAGER")
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
     * @Secure(roles="ROLE_MANAGER")
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
     * @Secure(roles="ROLE_MANAGER")
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
     * Deletes multiple entities
     * @Secure(roles="ROLE_MANAGER")
     */
    public function removeAction(Request $request)
    {
        $ids = $request->get('entities');
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('BenDoctorsBundle:Meds')->search(array('ids'=>$ids));
        foreach( $entities as $entity) $em->remove($entity);
        $em->flush();

        return new Response('1');
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
