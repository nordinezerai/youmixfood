<?php

namespace NZ\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass="NZ\PlatformBundle\Entity\PictureRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Picture
{
   /**
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;

  /**
   * @ORM\Column(name="url", type="string", length=255)
   */
  private $url;

  /**
   * @ORM\Column(name="alt", type="string", length=255)
   */
  private $alt;
  
  private $file;
  
  private $tempFilename;
  
  // Getters et setters

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
     * Set url
     *
     * @param string $url
     * @return Picture
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set alt
     *
     * @param string $alt
     * @return Picture
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get alt
     *
     * @return string 
     */
    public function getAlt()
    {
        return $this->alt;
    }
    
    public function getFile()
    {
    	return $this->file;
    }
    
    public function setFile(UploadedFile $file = null)
    {
    	$this->file = $file;
    	
    	if (null !== $this->url) {

    		$this->tempFilename = $this->url;
    		$this->url = null;
    		$this->alt = null;
    	}
    }
    
    public function getUploadDir()
    {
    	return 'uploads/img';
    }
    
    protected function getUploadRootDir()
    {
    	return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }
    
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
    	if (null === $this->file) {
    		return;
    	}

    	$this->url = $this->file->guessExtension();

    	$this->alt = $this->file->getClientOriginalName();
    }
    
    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
    	if (null === $this->file) {
    		return;
    	}

    	if (null !== $this->tempFilename) {
    		$oldFile = $this->getUploadRootDir().'/'.$this->id.'.'.$this->tempFilename;
    		if (file_exists($oldFile)) {
    			unlink($oldFile);
    		}
    	}
    
    	$this->file->move(
    			$this->getUploadRootDir(), 
    			$this->id.'.'.$this->url   
    			);
    }
    
    /**
     * @ORM\PreRemove()
     */
    public function preRemoveUpload()
    {

    	$this->tempFilename = $this->getUploadRootDir().'/'.$this->id.'.'.$this->url;
    }
    
    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
    	if (file_exists($this->tempFilename)) {

    		unlink($this->tempFilename);
    	}
    }
    
    public function getWebPath()
    {
    	return $this->getUploadDir().'/'.$this->getId().'.'.$this->getUrl();
    }
}
