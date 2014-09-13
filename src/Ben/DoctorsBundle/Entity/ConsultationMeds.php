<?php

namespace Ben\DoctorsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ConsultationMeds
 *
 * @ORM\Table(name="consultation_meds")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class ConsultationMeds
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="count", type="integer")
     */
    private $count;
    
    /**
    * @ORM\ManyToOne(targetEntity="Ben\DoctorsBundle\Entity\Consultation", inversedBy="consultationmeds")
    * @ORM\JoinColumn(name="consultation_id", referencedColumnName="id", nullable=false)
    */
    protected $consultation;

    /**
    * @ORM\ManyToOne(targetEntity="Ben\DoctorsBundle\Entity\Meds", inversedBy="consultationmeds")
    * @ORM\JoinColumn(name="meds_id", referencedColumnName="id", nullable=false)
    */
    protected $meds;
    
    /************ constructeur ************/
    
    public function __construct()
    {
        $this->consultations = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set count
     *
     * @param integer $count
     * @return Meds
     */
    public function setCount($count)
    {
        $this->count = $count;

        return $this;
    }

    /**
     * Get count
     *
     * @return integer 
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Set consultation
     *
     * @param \Ben\DoctorsBundle\Entity\Consultation $consultation
     * @return ConsultationMeds
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
     * Set meds
     *
     * @param \Ben\DoctorsBundle\Entity\Meds $meds
     * @return ConsultationMeds
     */
    public function setMeds(\Ben\DoctorsBundle\Entity\Meds $meds)
    {
        $this->meds = $meds;

        return $this;
    }

    /**
     * Get meds
     *
     * @return \Ben\DoctorsBundle\Entity\Meds 
     */
    public function getMeds()
    {
        return $this->meds;
    }

    /**
     * @ORM\PreRemove()
     */
    public function updateMeds()
    {
        $this->meds->minusCount($this->count * (-1));
    }
}
