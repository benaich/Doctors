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
        $stats['general_consultations_count'] = $statsHandler->setDataColumn('general_consultations')->processData()[0]['label'];
        $stats['special_consultations_count'] = $statsHandler->setDataColumn('special_consultations')->processData()[0]['label'];
        $stats['oriented_persons'] = $statsHandler->setDataColumn('oriented')->processData()[0]['label'];
       
        return $this->render('BenDoctorsBundle:Default:ajaxStats.html.twig', array(
            'stats' => $stats));
    }
}
