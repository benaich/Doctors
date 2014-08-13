<?php

namespace Ben\DoctorsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('BenDoctorsBundle:Default:index.html.twig', array('name' => ''));
    }
}
