<?php

namespace NZ\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use NZ\UserBundle\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Recipe
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="NZ\PlatformBundle\Entity\RecipeRepository")
 */
class Recipe
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
     * @ORM\Column(name="difficult", type="string", length=255)
     */
    private $difficult;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="time", type="integer")
     */
    private $time;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="list_ingredient", type="text")
     */
    private $list_ingredient;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="views_number", type="integer")
     */
    private $views_number;
    
     /**
     * @ORM\Column(name="date", type="datetime")
     * @Assert\DateTime()
     */
 	 private $date;
 	 
 	 /**
 	  * @var integer
 	  *
 	  * @ORM\Column(name="person_number", type="integer")
 	  */
 	 private $person_number;
 	 
 	 /**
 	  * @var string
 	  *
 	  * @ORM\Column(name="description", type="string", length=255, nullable=true)
 	  */
 	  	
 	 private $description;
 	 
 	 /**
 	  * @ORM\OneToOne(targetEntity="NZ\PlatformBundle\Entity\Picture", cascade={"persist","remove"})
 	  * @ORM\JoinColumn(nullable=false)
 	  */
 	 private $picture;
 	 
 	 /**
 	  * @ORM\OneToOne(targetEntity="NZ\PlatformBundle\Entity\Video", cascade={"persist","remove"})
 	  * @ORM\JoinColumn(nullable=true)
 	  */
 	 private $video;
	
    /**
     * @ORM\ManyToOne(targetEntity="NZ\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;
    
    /**
     * @ORM\OneToMany(targetEntity="NZ\PlatformBundle\Entity\Operation", mappedBy="recipe", cascade={"persist","remove"})
     */
    private $operations;
    
    /**
     * Constructor
     */
    public function __construct()
    {  	
    	$this->operations = new \Doctrine\Common\Collections\ArrayCollection();
        $this->date = new \Datetime();     		     
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
     * Set name
     *
     * @param string $name
     * @return Recipe
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
     * Set time
     *
     * @param integer $time
     * @return Recipe
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
     * Set views_number
     *
     * @param integer $viewsNumber
     * @return Recipe
     */
    public function setViewsNumber($viewsNumber)
    {
        $this->views_number = $viewsNumber;

        return $this;
    }

    /**
     * Get views_number
     *
     * @return integer 
     */
    public function getViewsNumber()
    {
        return $this->views_number;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Recipe
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set picture
     *
     * @param \NZ\PlatformBundle\Entity\Picture $picture
     * @return Recipe
     */
    public function setPicture(\NZ\PlatformBundle\Entity\Picture $picture)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get picture
     *
     * @return \NZ\PlatformBundle\Entity\Picture 
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set user
     *
     * @param \NZ\UserBundle\Entity\User $user
     * @return Recipe
     */
    public function setUser(\NZ\UserBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \NZ\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add operations
     *
     * @param \NZ\PlatformBundle\Entity\Operation $operations
     * @return Recipe
     */
    public function addOperation(\NZ\PlatformBundle\Entity\Operation $operations)
    {		
        $this->operations[] = $operations;
        $operations->setRecipe($this);
        return $this;
    }

    /**
     * Remove operations
     *
     * @param \NZ\PlatformBundle\Entity\Operation $operations
     */
    public function removeOperation(\NZ\PlatformBundle\Entity\Operation $operations)
    {
        $this->operations->removeElement($operations);
    }
    
    public function setOperation($operations)
    {
    	if(!empty($operations) && $operations === $this->operations) {
    		reset($operations);
    		$operations[key($operations)] = clone current($operations);
    	}
    	$this->operations = $operations;
    	return $this;
    }

    /**
     * Get operations
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOperations()
    {
        return $this->operations;
    }

    /**
     * Set video
     *
     * @param \NZ\PlatformBundle\Entity\Video $video
     * @return Recipe
     */
    public function setVideo(\NZ\PlatformBundle\Entity\Video $video = null)
    {
        $this->video = $video;

        return $this;
    }

    /**
     * Get video
     *
     * @return \NZ\PlatformBundle\Entity\Video 
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Recipe
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
     * Set difficult
     *
     * @param string $difficult
     * @return Recipe
     */
    public function setDifficult($difficult)
    {
        $this->difficult = $difficult;

        return $this;
    }

    /**
     * Get difficult
     *
     * @return string 
     */
    public function getDifficult()
    {
        return $this->difficult;
    }

    /**
     * Set list_ingredient
     *
     * @param string $listIngredient
     * @return Recipe
     */
    public function setListIngredient($listIngredient)
    {
        $this->list_ingredient = $listIngredient;

        return $this;
    }

    /**
     * Get list_ingredient
     *
     * @return string 
     */
    public function getListIngredient()
    {
        return $this->list_ingredient;
    }

    /**
     * Set person_number
     *
     * @param integer $personNumber
     * @return Recipe
     */
    public function setPersonNumber($personNumber)
    {
        $this->person_number = $personNumber;

        return $this;
    }

    /**
     * Get person_number
     *
     * @return integer 
     */
    public function getPersonNumber()
    {
        return $this->person_number;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Recipe
     */
    public function setDescription($description)
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
}
