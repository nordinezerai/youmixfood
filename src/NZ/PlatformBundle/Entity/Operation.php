<?php

namespace NZ\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Operation
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="NZ\PlatformBundle\Entity\OperationRepository")
 */
class Operation
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
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;
    
    /**
     * @ORM\OneToOne(targetEntity="NZ\PlatformBundle\Entity\Gif", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $gif;
    
    /**
     * @ORM\ManyToOne(targetEntity="NZ\PlatformBundle\Entity\Recipe", inversedBy="operations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $recipe;
    
    /**
     * @ORM\OneToMany(targetEntity="NZ\PlatformBundle\Entity\Etape", mappedBy="operation", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $etape;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->etape = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set description
     *
     * @param string $description
     * @return Operation
     */
    public function setDescription($description = null)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set recipe
     *
     * @param \NZ\PlatformBundle\Entity\Recipe $recipe
     * @return Operation
     */
    public function setRecipe(\NZ\PlatformBundle\Entity\Recipe $recipe)
    {
        $this->recipe = $recipe;

        return $this;
    }

    /**
     * Get recipe
     *
     * @return \NZ\PlatformBundle\Entity\Recipe 
     */
    public function getRecipe()
    {
        return $this->recipe;
    }

    /**
     * Add etape
     *
     * @param \NZ\PlatformBundle\Entity\Etape $etape
     * @return Operation
     */
    public function addEtape(\NZ\PlatformBundle\Entity\Etape $etape)
    {
        $this->etape[] = $etape;
		$etape->setOperation($this);
        return $this;
    }

    /**
     * Remove etape
     *
     * @param \NZ\PlatformBundle\Entity\Etape $etape
     */
    public function removeEtape(\NZ\PlatformBundle\Entity\Etape $etape)
    {
        $this->etape->removeElement($etape);
    }
    
    public function setEtape($etapes)
    {
    	if(!empty($etapes) && $etapes === $this->etape) {
    		reset($etapes);
    		$etapes[key($etapes)] = clone current($etapes);
    	}
    	$this->etape = $etapes;
    	return $this;
    }

    /**
     * Get etape
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEtape()
    {
        return $this->etape;
    }

    /**
     * Set gif
     *
     * @param \NZ\PlatformBundle\Entity\Gif $gif
     * @return Operation
     */
    public function setGif(\NZ\PlatformBundle\Entity\Gif $gif = null)
    {
        $this->gif = $gif;

        return $this;
    }

    /**
     * Get gif
     *
     * @return \NZ\PlatformBundle\Entity\Gif 
     */
    public function getGif()
    {
        return $this->gif;
    }
}
