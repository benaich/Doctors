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

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

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
     * @var string
     *
     * @ORM\Column(name="symptomes", type="text", nullable=true)
     */
    private $symptomes;

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
        $this->metadata = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Test
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
     * Add metadata
     *
     * @param \Ben\DoctorsBundle\Entity\Metadata $metadata
     * @return Test
     */
    public function addMetadatum(\Ben\DoctorsBundle\Entity\Metadata $metadata)
    {
        $metadata->setTest($this);
        $this->metadata->add($metadata);

        return $this;
    }

    /**
     * Remove metadata
     *
     * @param \Ben\DoctorsBundle\Entity\Metadata $metadata
     */
    public function removeMetadatum(\Ben\DoctorsBundle\Entity\Metadata $metadata)
    {
        $this->metadata->removeElement($metadata);
    }

    /**
     * Get metadata
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMetadata()
    {
        return $this->metadata;
    }
}
