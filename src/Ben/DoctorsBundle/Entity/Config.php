<?php

namespace Ben\DoctorsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Config
 *
 * @ORM\Table(name="config")
 * @ORM\Entity(repositoryClass="Ben\DoctorsBundle\Entity\ConfigRepository")
 */
class Config
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
     * @ORM\Column(name="the_key", type="string", length=255)
     */
    private $theKey;

    /**
     * @var string
     *
     * @ORM\Column(name="the_value", type="text")
     */
    private $theValue;


    public function __construct($the_key='', $the_value='') {
        $this->the_key = $the_key;
        $this->the_value = $the_value;
    }

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
     * Set theKey
     *
     * @param string $theKey
     * @return Config
     */
    public function setTheKey($theKey)
    {
        $this->theKey = $theKey;

        return $this;
    }

    /**
     * Get theKey
     *
     * @return string 
     */
    public function getTheKey()
    {
        return $this->theKey;
    }

    /**
     * Set theValue
     *
     * @param string $theValue
     * @return Config
     */
    public function setTheValue($theValue)
    {
        $this->theValue = $theValue;

        return $this;
    }

    /**
     * Get theValue
     *
     * @return string 
     */
    public function getTheValue()
    {
        return $this->theValue;
    }
}
