<?php

namespace Ben\DoctorsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Ben\DoctorsBundle\Entity\image
 *
 * @ORM\Table(name="image")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class image
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $path;
    
    /**
    * @var file $file
    * @Assert\File(
    *      maxSize = "2M",
    *      mimeTypes = {"image/jpeg", "image/pjpeg", "image/png", "image/x-png", "image/gif"},
    *      mimeTypesMessage = "ce format d'image est inconnu",
    *      uploadIniSizeErrorMessage = "Le fichier téléchargé est trop volumineux",
    *      uploadFormSizeErrorMessage = "Le fichier téléchargé est plus grand que celui autorisé par le champ de saisie du fichier HTML",
    *      uploadErrorMessage = "Le fichier téléchargé ne peut être transféré pour une raison inconnue",
    *      maxSizeMessage = "Le fichier est trop volumineux"
    * )
    */
    private $file;
    
    // propriété utilisé temporairement pour la suppression
    private $filenameForRemove;
    
     /************ Le constructeur ************/
    
    public function __construct()
    {
        $this->alt = 'image';
        $this->path= 'anonymous.png';
    }
    
    /************ Les setters et getters ************/

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    
    public function getFile()
    {
        return $this->file;
    }
    
    public function setFile($file)
    {
        $this->file = $file;
    
        return $this;
    }

   
    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }
     /**
     * Set path
     *
     * @param Ben\DoctorsBundle\Entity\image $path
     * @return profil
     */
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }
    
    public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path ? null : $this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadRootDir()
    {
        // le chemin absolu du répertoire où les documents uploadés doivent être sauvegardés
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        return 'uploads/img';
    }
  
    public function upload()
    {
        // var_dump(pathinfo($this->file, PATHINFO_EXTENSION));die();
        if (null === $this->file) return false;
        else $this->path = sha1(uniqid(mt_rand(), true)).'.'.$this->file->guessExtension();

        $this->file->move($this->getUploadRootDir(), $this->path);
        unset($this->file);
        return true;
    }

    /**
     * @ORM\PreRemove()
     */
    public function storeFilenameForRemove()
    {
        $this->filenameForRemove = $this->getAbsolutePath();
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        $default1=$this->getUploadRootDir().'/anonymous.png';
        $default2=$this->getUploadRootDir().'/unknown.png';
        $default3=$this->getUploadRootDir().'/jpeg.png';
        if ($this->filenameForRemove and $this->filenameForRemove != $default1 and $this->filenameForRemove != $default2) {
            unlink($this->filenameForRemove);
        }
    }
    public function manualRemove($filenameForRemove)
    {
       if (null === $this->file) return;
        $default1=$this->getUploadRootDir().'/anonymous.png';
        $default2=$this->getUploadRootDir().'/unknown.png';
        $default3=$this->getUploadRootDir().'/jpeg.png';
        
        if ($filenameForRemove != $default1 and $filenameForRemove != $default2 and $filenameForRemove != $default3) {
            if (!preg_match("#http://#", $filenameForRemove))  unlink($filenameForRemove);
        }
    }
}