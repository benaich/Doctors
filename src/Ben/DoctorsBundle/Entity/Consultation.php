<?php

namespace Ben\DoctorsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Consultation
 *
 * @ORM\Table(name="consultation")
 * @ORM\Entity(repositoryClass="Ben\DoctorsBundle\Entity\ConsultationRepository")
 */
class Consultation
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    public static $GENERAL  = 'Consultation generale';
    public static $SPECIAL  = 'Consultation spécialisé';

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="motiftype", type="string", length=255, nullable=true)
     */
    private $motiftype;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="infrastructure", type="string", length=255, nullable=true)
     */
    private $infrastructure;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="date")
     */
    private $created;
    
   /**
     * @var string
     *
     * @ORM\Column(name="diagnosis", type="text", nullable=true)
     */
    private $diagnosis;
    
   /**
     * @var string
     *
     * @ORM\Column(name="treatment", type="text", nullable=true)
     */
    private $treatment;

    /**
     * @var string
     *
     * @ORM\Column(name="decision", type="text", nullable=true)
     */
    private $decision;

    /**
     * @var boolean
     *
     * @ORM\Column(name="chronic", type="boolean", nullable=true)
     */
    private $chronic;
    
    /**
    * @ORM\ManyToOne(targetEntity="Ben\DoctorsBundle\Entity\Person", inversedBy="consultations")
    * @ORM\JoinColumn(name="person_id", referencedColumnName="id", nullable=false)
    */
    private $person;
    
    /**
    * @ORM\ManyToOne(targetEntity="Ben\UserBundle\Entity\User", inversedBy="consultations")
    * @ORM\JoinColumn(name="doc_id", referencedColumnName="id", nullable=false)
    */
    private $user;

    /**
    * @ORM\OneToMany(targetEntity="Ben\DoctorsBundle\Entity\Test", mappedBy="consultation", cascade={"remove", "persist"})
    */
    protected $tests;

    /**
    * @ORM\OneToMany(targetEntity="Ben\DoctorsBundle\Entity\ConsultationMeds", mappedBy="consultation", cascade={"remove", "persist"})
    */
    protected $consultationmeds;
    
    /************ constructeur ************/
    
    public function __construct()
    {
        $this->created = new \DateTime;
        $this->type = Consultation::$GENERAL;
        $this->tests = new \Doctrine\Common\Collections\ArrayCollection();
        $this->consultationmeds = new \Doctrine\Common\Collections\ArrayCollection();
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

    public function __toString()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Consultation
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Consultation
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set person
     *
     * @param \Ben\DoctorsBundle\Entity\Person $person
     * @return Consultation
     */
    public function setPerson(\Ben\DoctorsBundle\Entity\Person $person)
    {
        $this->person = $person;

        return $this;
    }

    /**
     * Get person
     *
     * @return \Ben\DoctorsBundle\Entity\Person 
     */
    public function getPerson()
    {
        return $this->person;
    }

    /**
     * Set user
     *
     * @param \Ben\UserBundle\Entity\User $user
     * @return Consultation
     */
    public function setUser(\Ben\UserBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Ben\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add tests
     *
     * @param \Ben\DoctorsBundle\Entity\Test $tests
     * @return Consultation
     */
    public function addTest(\Ben\DoctorsBundle\Entity\Test $tests)
    {
        $this->tests[] = $tests;

        return $this;
    }

    /**
     * Remove tests
     *
     * @param \Ben\DoctorsBundle\Entity\Test $tests
     */
    public function removeTest(\Ben\DoctorsBundle\Entity\Test $tests)
    {
        $this->tests->removeElement($tests);
    }

    /**
     * Get tests
     *
     * @return \Doctrine\Common\Collections\ArrayCollection 
     */
    public function getTests()
    {
        return $this->tests;
    }

    /**
     * Add consultationmeds
     *
     * @param \Ben\DoctorsBundle\Entity\ConsultationMeds $consultationmeds
     * @return Consultation
     */
    public function addConsultationmed(\Ben\DoctorsBundle\Entity\ConsultationMeds $consultationmeds)
    {
        $consultationmeds->setConsultation($this);
        $this->consultationmeds->add($consultationmeds);

        return $this;
    }

    /**
     * Remove consultationmeds
     *
     * @param \Ben\DoctorsBundle\Entity\ConsultationMeds $consultationmeds
     */
    public function removeConsultationmed(\Ben\DoctorsBundle\Entity\ConsultationMeds $consultationmeds)
    {
        $this->consultationmeds->removeElement($consultationmeds);
    }

    /**
     * Get consultationmeds
     *
     * @return \Doctrine\Common\Collections\ArrayCollection 
     */
    public function getConsultationmeds()
    {
        return $this->consultationmeds;
    }

    /**
     * Set diagnosis
     *
     * @param string $diagnosis
     * @return Consultation
     */
    public function setDiagnosis($diagnosis)
    {
        $this->diagnosis = $diagnosis;

        return $this;
    }

    /**
     * Get diagnosis
     *
     * @return string 
     */
    public function getDiagnosis()
    {
        return $this->diagnosis;
    }

    /**
     * Set treatment
     *
     * @param string $treatment
     * @return Consultation
     */
    public function setTreatment($treatment)
    {
        $this->treatment = $treatment;

        return $this;
    }

    /**
     * Get treatment
     *
     * @return string 
     */
    public function getTreatment()
    {
        return $this->treatment;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Consultation
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

    /**
     * Set motiftype
     *
     * @param string $motiftype
     * @return Consultation
     */
    public function setMotiftype($motiftype)
    {
        $this->motiftype = $motiftype;

        return $this;
    }

    /**
     * Get motiftype
     *
     * @return string 
     */
    public function getMotiftype()
    {
        return $this->motiftype;
    }

    /**
     * Set infrastructure
     *
     * @param string $infrastructure
     * @return Consultation
     */
    public function setInfrastructure($infrastructure)
    {
        $this->infrastructure = $infrastructure;

        return $this;
    }

    /**
     * Get infrastructure
     *
     * @return string 
     */
    public function getInfrastructure()
    {
        return $this->infrastructure;
    }
    
    public function isSpecial()
    {
        return ($this->type === Consultation::$SPECIAL);
    }

    /**
     * Set chronic
     *
     * @param boolean $chronic
     * @return Consultation
     */
    public function setChronic($chronic)
    {
        $this->chronic = $chronic;

        return $this;
    }

    /**
     * Get chronic
     *
     * @return boolean 
     */
    public function getChronic()
    {
        return $this->chronic;
    }
    
    /**
     * Set decision
     *
     * @param string $decision
     * @return Consultation
     */
    public function setDecision($decision)
    {
        $this->decision = $decision;

        return $this;
    }

    /**
     * Get decision
     *
     * @return string 
     */
    public function getDecision()
    {
        return $this->decision;
    }
}
