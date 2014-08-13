<?php

namespace Ben\DoctorsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Metadata
 *
 * @ORM\Table(name="metadata")
 * @ORM\Entity(repositoryClass="Ben\DoctorsBundle\Entity\MetadataRepository")
 */
class Metadata
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
     * @ORM\Column(name="thekey", type="string", length=255)
     */
    private $thekey;

    /**
     * @var string
     *
     * @ORM\Column(name="thevalue", type="string", length=255)
     */
    private $thevalue;
    
    /**
    * @ORM\ManyToOne(targetEntity="Ben\DoctorsBundle\Entity\Test", inversedBy="metadata")
    * @ORM\JoinColumn(name="test_id", referencedColumnName="id", nullable=false)
    */
    private $test;
    
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
     * Set thekey
     *
     * @param string $thekey
     * @return Metadata
     */
    public function setThekey($thekey)
    {
        $this->thekey = $thekey;

        return $this;
    }

    /**
     * Get thekey
     *
     * @return string 
     */
    public function getThekey()
    {
        return $this->thekey;
    }

    /**
     * Set thevalue
     *
     * @param string $thevalue
     * @return Metadata
     */
    public function setThevalue($thevalue)
    {
        $this->thevalue = $thevalue;

        return $this;
    }

    /**
     * Get thevalue
     *
     * @return string 
     */
    public function getThevalue()
    {
        return $this->thevalue;
    }

    /**
     * Set test
     *
     * @param \Ben\DoctorsBundle\Entity\Test $test
     * @return Metadata
     */
    public function setTest(\Ben\DoctorsBundle\Entity\Test $test)
    {
        $this->test = $test;

        return $this;
    }

    /**
     * Get test
     *
     * @return \Ben\DoctorsBundle\Entity\Test 
     */
    public function getTest()
    {
        return $this->test;
    }
}
