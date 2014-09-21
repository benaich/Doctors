<?php

namespace Ben\DoctorsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Httpfoundation\Response;
use JMS\SecurityExtraBundle\Annotation\Secure;

class DefaultController extends Controller
{
    /**
     * @Secure(roles="ROLE_USER")
     */
    public function indexAction()
    {       
        return $this->render('BenDoctorsBundle:Default:index.html.twig');
    }

    /**
     * @Secure(roles="ROLE_USER")
     */
    public function statsAction(Request $request)
    {
        $daterange = $request->get('daterange');
        $statsHandler = $this->get('ben.stats_handler')->setDateRange($daterange);
        $availableWidgets = ['meds', 'stock', 'cnss', 'consultations_demande', 'consultations_demande_gender', 'consultations_demande_resident',
                         'consultations_demande_resident_gender', 'consultations_systematique_resident', 'consultations_systematique_resident_gender',
                          'consultations_visual_issue', 'consultations_special', 'consultations_special_gender', 'consultations_chronic', 
                          'consultations_not_chronic', 'consultations_structures'];
        $widgets = $request->get('widgets');
        $stats = [];
        if (isset($widgets)) {
            foreach ($widgets as $key => $val) {
                if(in_array($key, $availableWidgets))
                    $stats[$key] = $statsHandler->setDataColumn($key)->processData();
            }
        }
       
        return $this->render('BenDoctorsBundle:Default:ajaxStats.html.twig', array(
            'stats' => $stats));
    }
}