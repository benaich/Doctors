<?php

namespace Ben\DoctorsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Meds
 *
 * @ORM\Table(name="meds")
 * @ORM\Entity(repositoryClass="Ben\DoctorsBundle\Entity\MedsRepository")
 */
class Meds
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="count", type="integer")
     */
    private $count;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;
    
   /**
     * @var string
     *
     * @ORM\Column(name="about", type="text", nullable=true)
     */
    private $about;

    /**
     * @var \DateTime $created
     *
     * @ORM\Column(name="created", type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    protected $created;

    /**
     * @var \DateTime $expdate
     *
     * @ORM\Column(name="expdate", type="date")
     * @Gedmo\Timestampable(on="create")
     */
    protected $expdate;

    /**
    * @ORM\OneToMany(targetEntity="Ben\DoctorsBundle\Entity\ConsultationMeds", mappedBy="meds", cascade={"remove", "persist"})
    */
    protected $consultationmeds;

    
    /************ constructeur ************/
    
    public function __construct()
    {
        $this->consultationmeds = new \Doctrine\Common\Collections\ArrayCollection();
        $this->created = new \DateTime;
        $this->expdate = new \DateTime;
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
     * toString
     *
     * @return string 
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Meds
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
     * minus count
     *
     * @param string $count
     * @return Meds
     */
    public function minusCount($count)
    {
        $this->count -= $count;

        return $this;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Meds
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
     * Set about
     *
     * @param string $about
     * @return Meds
     */
    public function setAbout($about)
    {
        $this->about = $about;

        return $this;
    }

    /**
     * Get about
     *
     * @return string 
     */
    public function getAbout()
    {
        return $this->about;
    }

    /**
     * Add consultationmeds
     *
     * @param \Ben\DoctorsBundle\Entity\ConsultationMeds $consultationmeds
     * @return Meds
     */
    public function addConsultationmed(\Ben\DoctorsBundle\Entity\ConsultationMeds $consultationmeds)
    {
        $this->consultationmeds[] = $consultationmeds;

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
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getConsultationmeds()
    {
        return $this->consultationmeds;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Meds
     */
    public function setCreated($created) {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated() {
        return $this->created;
    }

    /**
     * Set expdate
     *
     * @param \DateTime $expdate
     * @return Meds
     */
    public function setExpdate($expdate) {
        $this->expdate = $expdate;

        return $this;
    }

    /**
     * Get expdate
     *
     * @return \DateTime 
     */
    public function getExpdate() {
        return $this->expdate;
    }

    /**
     * check expiration date
     *
     * @return boolean
     */
    public function isExpired()
    {
        return ($this->expdate <= new \DateTime());
    }
}
