<?php

namespace NZ\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use NZ\PlatformBundle\Entity\Ingredient;

class AjaxController extends Controller
{

		/**
		 * @Route("/ajax_recipe", name="ajax_recipe")
		 */
		public function ajaxRecipeAction(Request $request)
	    {
	       $value = $request->get('name_startsWith');
	 
	       $em = $this->getDoctrine()->getEntityManager();
	       $recipes = $em->getRepository('NZPlatformBundle:Recipe')->getRecipeWithKeyword($value);
	 
	       $json = array();
	       foreach ($recipes as $recipe) {
	           $json[] = array(
	               'label' => $recipe->getName(),
	               'value' => $recipe->getId()
	           );
	       }
	 
	       $response = new Response();
	       $response->setContent(json_encode($json));
	 	
	       return $response;
	    }
	   
	    /**
	     * @Route("/ajax_ingredient", name="ajax_ingredient")
	     */
	    public function ajaxIngredientAction(Request $request)
	    {
	       $value = $request->get('name_startsWith');
	 
	       $em = $this->getDoctrine()->getEntityManager();
	       $ingredients = $em->getRepository('NZPlatformBundle:Ingredient')->getIngredientWithKeyword($value);
	 
	       $json = array();
	       foreach ($ingredients as $ingredient) {
	           $json[] = array(
	               'label' => $ingredient->getName(),
	               'value' => $ingredient->getId()
	           );
	       }
	 
	       $response = new Response();
	       $response->setContent(json_encode($json));
	 	
	       return $response;
	    }
	    
	    /**
	     * @Route("/ajax_appareil", name="ajax_appareil")
	     */
	    public function ajaxAppareilAction(Request $request)
	    {
	    	$value = $request->get('name_startsWith');
	    
	    	$em = $this->getDoctrine()->getEntityManager();
	    	$appareils = $em->getRepository('NZPlatformBundle:Appareil')->getAppareilWithKeyword($value);
	    
	    	$json = array();
	    	foreach ($appareils as $appareil) {
	    		$json[] = array(
	    				'label' => $appareil->getName(),
	    				'value' => $appareil->getId()
	    		);
	    	}
	    
	    	$response = new Response();
	    	$response->setContent(json_encode($json));
	    	 
	    	return $response;
	    }
	    
	    /**
	     * @Route("/ajax_ustensile", name="ajax_ustensile")
	     */
	    public function ajaxUstensileAction(Request $request)
	    {
	    	$value = $request->get('name_startsWith');
	    	 
	    	$em = $this->getDoctrine()->getEntityManager();
	    	$ustensiles = $em->getRepository('NZPlatformBundle:Ustensile')->getUstensileWithKeyword($value);
	    	 
	    	$json = array();
	    	foreach ($ustensiles as $ustensile) {
	    		$json[] = array(
	    				'label' => $ustensile->getName(),
	    				'value' => $ustensile->getId()
	    		);
	    	}
	    	 
	    	$response = new Response();
	    	$response->setContent(json_encode($json));
	    	 
	    	return $response;
	    }
	    
	    /**
	     * @Route("/ajax_action", name="ajax_action")
	     */
	    public function ajaxActionAction(Request $request)
	    {
	    	$value = $request->get('name_startsWith');
	    	 
	    	$em = $this->getDoctrine()->getEntityManager();
	    	$actions = $em->getRepository('NZPlatformBundle:Action')->getActionWithKeyword($value);
	    	 
	    	$json = array();
	    	foreach ($actions as $action) {
	    		$json[] = array(
	    				'label' => $action->getName(),
	    				'value' => $action->getId()
	    		);
	    	}
	    	 
	    	$response = new Response();
	    	$response->setContent(json_encode($json));
	    	 
	    	return $response;
	    }
	   
	    /**
	     * @Route("/ajax_multiple_ingredient", name="ajax_multiple_ingredient")
	     */
	    public function ajaxMultipleIngredientAction(Request $request)
	    {
		   	$value = $_GET['name_startsWith'];
		   	$em = $this->getDoctrine()->getEntityManager();
		   	$ingredients = $em->getRepository('NZPlatformBundle:Ingredient')->getIngredientWithKeyword($value);
		   
		   	$json = array();
		   	foreach ($ingredients as $ingredient) {
		   		$json[] = array(
		   				'id' => $ingredient->getName(),
		   				'text' => $ingredient->getName()
		   		);
	   	 }
	   
	     $response = new Response();
	   
	   	 $response->setContent(json_encode(array('q' => $value, 'results' => $json)));
	   	  
	   	 return $response;
	    }
	   
	}