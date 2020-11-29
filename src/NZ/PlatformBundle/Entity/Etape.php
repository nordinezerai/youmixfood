<?php

namespace NZ\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Etape
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Etape
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
     * @ORM\Column(name="quantity", type="integer", nullable=true)
     */
    private $quantity;

    /**
     * @var integer
     *
     * @ORM\Column(name="power", type="integer", nullable=true)
     */
    private $power;

    /**
     * @var string
     *
     * @ORM\Column(name="um_quantity", type="string", length=10, nullable=true)
     */
    private $um_quantity;
    
    /**
     * @var string
     *
     * @ORM\Column(name="um_power", type="string", length=10, nullable=true)
     */
    private $um_power;

    /**
     * @var integer
     *
     * @ORM\Column(name="time", type="integer", nullable=true)
     */
    private $time;
    
    /**
     * @var string
     *
     * @ORM\Column(name="typeEtape", type="string", length=10)
     */
    private $typeEtape;
    
    /**
     * @ORM\ManyToOne(targetEntity="NZ\PlatformBundle\Entity\Operation", inversedBy="etape")
     * @ORM\JoinColumn(nullable=false)
     */
    private $operation;
    
    /**
     * @ORM\ManyToOne(targetEntity="NZ\PlatformBundle\Entity\Ingredient", cascade={"persist"})
     */
    private $ingredient;
    
    /**
     * @ORM\ManyToOne(targetEntity="NZ\PlatformBundle\Entity\Appareil", cascade={"persist"})
     */
    private $appareil;
    
    /**
     * @ORM\ManyToOne(targetEntity="NZ\PlatformBundle\Entity\Ustensile", cascade={"persist"})
     */
    private $ustensile;
    
    /**
     * @ORM\ManyToOne(targetEntity="NZ\PlatformBundle\Entity\Action", cascade={"persist"})
     */
    private $action;

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
     * Set quantity
     *
     * @param integer $quantity
     * @return Etape
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer 
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set power
     *
     * @param integer $power
     * @return Etape
     */
    public function setPower($power)
    {
        $this->power = $power;

        return $this;
    }

    /**
     * Get power
     *
     * @return integer 
     */
    public function getPower()
    {
        return $this->power;
    }	

    /**
     * Set um_quantity
     *
     * @param string $umQuantity
     * @return Etape
     */
    public function setUmQuantity($umQuantity)
    {
    	$this->um_quantity = $umQuantity;
    
    	return $this;
    }
    
    /**
     * Get um_quantity
     *
     * @return string
     */
    public function getUmQuantity()
    {
    	return $this->um_quantity;
    }
    
    /**
     * Set um_power
     *
     * @param string $umPower
     * @return Etape
     */
    public function setUmPower($umPower)
    {
    	$this->um_power = $umPower;
    
    	return $this;
    }
    
    /**
     * Get um_power
     *
     * @return string
     */
    public function getUmPower()
    {
    	return $this->um_power;
    }
    
    /**
     * Set time
     *
     * @param integer $time
     * @return Etape
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get time
     *
     * @return integer 
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set operation
     *
     * @param \NZ\PlatformBundle\Entity\Operation $operation
     * @return Etape
     */
    public function setOperation(\NZ\PlatformBundle\Entity\Operation $operation)
    {
        $this->operation = $operation;

        return $this;
    }

    /**
     * Get operation
     *
     * @return \NZ\PlatformBundle\Entity\Operation 
     */
    public function getOperation()
    {
        return $this->operation;
    }


    /**
     * Set ingredient
     *
     * @param \NZ\PlatformBundle\Entity\Ingredient $ingredient
     * @return Etape
     */
    public function setIngredient(\NZ\PlatformBundle\Entity\Ingredient $ingredient = null)
    {
    	
        $this->ingredient = $ingredient;
		
        return $this;
    }

    /**
     * Get ingredient
     *
     * @return \NZ\PlatformBundle\Entity\Ingredient 
     */
    public function getIngredient()
    {
        return $this->ingredient;
    }

    /**
     * Set appareil
     *
     * @param \NZ\PlatformBundle\Entity\Appareil $appareil
     * @return Etape
     */
    public function setAppareil(\NZ\PlatformBundle\Entity\Appareil $appareil = null)
    {
        $this->appareil = $appareil;

        return $this;
    }

    /**
     * Get appareil
     *
     * @return \NZ\PlatformBundle\Entity\Appareil 
     */
    public function getAppareil()
    {
        return $this->appareil;
    }

    /**
     * Set action
     *
     * @param \NZ\PlatformBundle\Entity\Action $action
     * @return Etape
     */
    public function setAction(\NZ\PlatformBundle\Entity\Action $action = null)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Get action
     *
     * @return \NZ\PlatformBundle\Entity\Action 
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Set ustensile
     *
     * @param \NZ\PlatformBundle\Entity\Ustensile $ustensile
     * @return Etape
     */
    public function setUstensile(\NZ\PlatformBundle\Entity\Ustensile $ustensile = null)
    {
        $this->ustensile = $ustensile;

        return $this;
    }

    /**
     * Get ustensile
     *
     * @return \NZ\PlatformBundle\Entity\Ustensile 
     */
    public function getUstensile()
    {
        return $this->ustensile;
    }

    /**
     * Set typeEtape
     *
     * @param string $typeEtape
     * @return Etape
     */
    public function setTypeEtape($typeEtape)
    {
        $this->typeEtape = $typeEtape;

        return $this;
    }

    /**
     * Get typeEtape
     *
     * @return string 
     */
    public function getTypeEtape()
    {
        return $this->typeEtape;
    }
}
