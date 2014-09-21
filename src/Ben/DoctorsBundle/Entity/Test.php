<?php

namespace Ben\DoctorsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Test
 *
 * @ORM\Table(name="test")
 * @ORM\Entity(repositoryClass="Ben\DoctorsBundle\Entity\TestRepository")
 */
class Test
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    public static $GENERAL  = 'Examen Générale';

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="taille", type="string", length=255, nullable=true)
     */
    private $taille;

    /**
     * @var string
     *
     * @ORM\Column(name="poids", type="string", length=255, nullable=true)
     */
    private $poids;

    /**
     * @var string
     *
     * @ORM\Column(name="ta", type="string", length=255, nullable=true)
     */
    private $ta;

    /**
     * @var string
     *
     * @ORM\Column(name="od", type="string", length=255, nullable=true)
     */
    private $od;

    /**
     * @var string
     *
     * @ORM\Column(name="og", type="string", length=255, nullable=true)
     */
    private $og;

    /**
     * @var boolean
     *
     * @ORM\Column(name="hasvisualissue", type="boolean", nullable=true)
     */
    private $hasvisualissue;

    /**
     * @var boolean
     *
     * @ORM\Column(name="fixedvisualissue", length=255, nullable=true)
     */
    private $fixedvisualissue;

    /**
     * @var string
     *
     * @ORM\Column(name="request", type="text", nullable=true)
     */
    private $request;
    /**
     * @var string
     *
     * @ORM\Column(name="result", type="text", nullable=true)
     */
    private $result;
    
    /**
    * @ORM\ManyToOne(targetEntity="Ben\DoctorsBundle\Entity\Consultation", inversedBy="tests")
    * @ORM\JoinColumn(name="consultation_id", referencedColumnName="id", nullable=false)
    */
    private $consultation;
    
    /************ constructeur ************/
    
    public function __construct()
    {
    }
    
    /************ getters & setters  ************/

   /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Test
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }
    public function isGeneral()
    {
        return ($this->type === Test::$GENERAL);
    }

    /**
     * Set consultation
     *
     * @param \Ben\DoctorsBundle\Entity\Consultation $consultation
     * @return Test
     */
    public function setConsultation(\Ben\DoctorsBundle\Entity\Consultation $consultation)
    {
        $this->consultation = $consultation;

        return $this;
    }

    /**
     * Get consultation
     *
     * @return \Ben\DoctorsBundle\Entity\Consultation 
     */
    public function getConsultation()
    {
        return $this->consultation;
    }

    /**
     * Set taille
     *
     * @param string $taille
     * @return Test
     */
    public function setTaille($taille)
    {
        $this->taille = $taille;

        return $this;
    }

    /**
     * Get taille
     *
     * @return string 
     */
    public function getTaille()
    {
        return $this->taille;
    }

    /**
     * Set poids
     *
     * @param string $poids
     * @return Test
     */
    public function setPoids($poids)
    {
        $this->poids = $poids;

        return $this;
    }

    /**
     * Get poids
     *
     * @return string 
     */
    public function getPoids()
    {
        return $this->poids;
    }

    /**
     * Set ta
     *
     * @param string $ta
     * @return Test
     */
    public function setTa($ta)
    {
        $this->ta = $ta;

        return $this;
    }

    /**
     * Get ta
     *
     * @return string 
     */
    public function getTa()
    {
        return $this->ta;
    }

    /**
     * Set od
     *
     * @param string $od
     * @return Test
     */
    public function setOd($od)
    {
        $this->od = $od;

        return $this;
    }

    /**
     * Get od
     *
     * @return string 
     */
    public function getOd()
    {
        return $this->od;
    }

    /**
     * Set og
     *
     * @param string $og
     * @return Test
     */
    public function setOg($og)
    {
        $this->og = $og;

        return $this;
    }

    /**
     * Get og
     *
     * @return string 
     */
    public function getOg()
    {
        return $this->og;
    }

    /**
     * Set request
     *
     * @param string $request
     * @return Test
     */
    public function setRequest($request)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * Get request
     *
     * @return string 
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Set result
     *
     * @param string $result
     * @return Test
     */
    public function setResult($result)
    {
        $this->result = $result;

        return $this;
    }

    /**
     * Get result
     *
     * @return string 
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Set hasvisualissue
     *
     * @param boolean $hasvisualissue
     * @return Test
     */
    public function setHasvisualissue($hasvisualissue)
    {
        $this->hasvisualissue = $hasvisualissue;

        return $this;
    }

    /**
     * Get hasvisualissue
     *
     * @return boolean 
     */
    public function getHasvisualissue()
    {
        return $this->hasvisualissue;
    }

    /**
     * Set fixedvisualissue
     *
     * @param string $fixedvisualissue
     * @return Test
     */
    public function setFixedvisualissue($fixedvisualissue)
    {
        $this->fixedvisualissue = $fixedvisualissue;

        return $this;
    }

    /**
     * Get fixedvisualissue
     *
     * @return string 
     */
    public function getFixedvisualissue()
    {
        return $this->fixedvisualissue;
    }
}
