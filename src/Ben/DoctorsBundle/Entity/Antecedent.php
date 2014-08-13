<?php

namespace Ben\DoctorsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Antecedent
 *
 * @ORM\Table(name="antecedent")
 * @ORM\Entity(repositoryClass="Ben\DoctorsBundle\Entity\AntecedentRepository")
 */
class Antecedent
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
     * @ORM\Column(name="allergies", type="text", nullable=true)
     */
    private $allergies;

    /**
     * @var string
     *
     * @ORM\Column(name="autres", type="text", nullable=true)
     */
    private $autres;

    /**
     * @var string
     *
     * @ORM\Column(name="traitement", type="text", nullable=true)
     */
    private $traitement;

    /**
     * @var string
     *
     * @ORM\Column(name="chirurgicaux", type="text", nullable=true)
     */
    private $chirurgicaux;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;
    
    /**
    * @ORM\ManyToOne(targetEntity="Ben\DoctorsBundle\Entity\Person", inversedBy="antecedents")
    * @ORM\JoinColumn(name="person_id", referencedColumnName="id", nullable=false)
    */
    private $person;
    
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
     * Set allergies
     *
     * @param string $allergies
     * @return Antecedent
     */
    public function setAllergies($allergies)
    {
        $this->allergies = $allergies;

        return $this;
    }

    /**
     * Get allergies
     *
     * @return string 
     */
    public function getAllergies()
    {
        return $this->allergies;
    }

    /**
     * Set autres
     *
     * @param string $autres
     * @return Antecedent
     */
    public function setAutres($autres)
    {
        $this->autres = $autres;

        return $this;
    }

    /**
     * Get autres
     *
     * @return string 
     */
    public function getAutres()
    {
        return $this->autres;
    }

    /**
     * Set traitement
     *
     * @param string $traitement
     * @return Antecedent
     */
    public function setTraitement($traitement)
    {
        $this->traitement = $traitement;

        return $this;
    }

    /**
     * Get traitement
     *
     * @return string 
     */
    public function getTraitement()
    {
        return $this->traitement;
    }

    /**
     * Set chirurgicaux
     *
     * @param string $chirurgicaux
     * @return Antecedent
     */
    public function setChirurgicaux($chirurgicaux)
    {
        $this->chirurgicaux = $chirurgicaux;

        return $this;
    }

    /**
     * Get chirurgicaux
     *
     * @return string 
     */
    public function getChirurgicaux()
    {
        return $this->chirurgicaux;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Antecedent
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
     * Set person
     *
     * @param \Ben\DoctorsBundle\Entity\Person $person
     * @return Antecedent
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
}
