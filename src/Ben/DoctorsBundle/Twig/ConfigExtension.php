<?php

namespace Ben\DoctorsBundle\Twig;
use Doctrine\ORM\EntityManager;

class ConfigExtension extends \Twig_Extension {

    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getGlobals()
    {
        $logoConfig = $this->em->getRepository('BenDoctorsBundle:Config')->findAll();
        $result= [];
        foreach ($logoConfig as $cf) {
            $result[$cf->getTheKey()] = $cf->getTheValue();
        }
      return array(
        'app_config'=> $result,
      );
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName() {
        return 'config_extension';
    }

}