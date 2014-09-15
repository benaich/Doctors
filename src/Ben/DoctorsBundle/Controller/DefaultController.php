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
        $stats['meds'] = $statsHandler->setDataColumn('meds')->processData();
        $stats['consultations'] = $statsHandler->setDataColumn('consultations')->processData();
        $stats['stock'] = $statsHandler->setDataColumn('stock')->processData()[0]['label'];
        
        $stats['cnss'] = $statsHandler->setDataColumn('cnss')->processData();
        $stats['consultations_demande'] = $statsHandler->setDataColumn('consultations_demande')->processData()[0]['data'];
        $stats['consultations_demande_gender'] = $statsHandler->setDataColumn('consultations_demande_gender')->processData();
        $stats['consultations_demande_resident'] = $statsHandler->setDataColumn('consultations_demande_resident')->processData()[0]['data'];
        $stats['consultations_demande_resident_gender'] = $statsHandler->setDataColumn('consultations_demande_resident_gender')->processData();

        $stats['consultations_systematique_resident'] = $statsHandler->setDataColumn('consultations_systematique_resident')->processData()[0]['data'];
        $stats['consultations_systematique_resident_gender'] = $statsHandler->setDataColumn('consultations_systematique_resident_gender')->processData();
        $stats['consultations_visual_issue'] = $statsHandler->setDataColumn('consultations_visual_issue')->processData()[0]['data'];
        $stats['consultations_special'] = $statsHandler->setDataColumn('consultations_special')->processData();
        $stats['consultations_special_gender'] = $statsHandler->setDataColumn('consultations_special_gender')->processData();
        
        $stats['consultations_chronic'] = $statsHandler->setDataColumn('consultations_chronic')->processData()[0]['data'];
        $stats['consultations_not_chronic'] = $statsHandler->setDataColumn('consultations_not_chronic')->processData()[0]['data'];
        $stats['consultations_structures'] = $statsHandler->setDataColumn('consultations_structures')->processData();

        // var_dump($stats);die;
       
        return $this->render('BenDoctorsBundle:Default:ajaxStats.html.twig', array(
            'stats' => $stats));
    }
}
