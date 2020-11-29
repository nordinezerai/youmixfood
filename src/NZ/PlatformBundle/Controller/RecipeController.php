<?php

namespace NZ\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use NZ\PlatformBundle\Entity\SearchCriteria;
use NZ\PlatformBundle\Form\SearchCriteriaType;
use NZ\PlatformBundle\Entity\SearchByIngredients;
use NZ\PlatformBundle\Entity\Recipe;
use NZ\PlatformBundle\Form\RecipeType;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RecipeController extends Controller
{
  
  public function indexAction(Request $request)
  {
  	$em = $this->getDoctrine()->getManager();
  	
  	$recipeRepository = $em->getRepository('NZPlatformBundle:Recipe');

  	$recipesType1 = $recipeRepository->findBy(array('type' => 'Entrée'),array('date' => 'DESC'),6,0);
  	$recipesType2 = $recipeRepository->findBy(array('type' => 'Plat principal'),array('date' => 'DESC'),6,0);
  	$recipesType3 = $recipeRepository->findBy(array('type' => 'Dessert'),array('date' => 'DESC'),6,0);
  	$recipesType4 = $recipeRepository->findBy(array('type' => 'Accompagnement'),array('date' => 'DESC'),6,0);
  	$recipesType5 = $recipeRepository->findBy(array('type' => 'Amuse-gueule'),array('date' => 'DESC'),6,0);
  	$recipesType6 = $recipeRepository->findBy(array('type' => 'Boisson'),array('date' => 'DESC'),6,0);
  	$recipesType7 = $recipeRepository->findBy(array('type' => 'Confiserie'),array('date' => 'DESC'),6,0);
  	$recipesType8 = $recipeRepository->findBy(array('type' => 'Sauce'),array('date' => 'DESC'),6,0);
  	
  	$recipes = array('Entrée'=>$recipesType1,'Plat principal'=>$recipesType2,'Dessert'=>$recipesType3,'Accompagnement'=>$recipesType4,'Amuse-gueule'=>$recipesType5,'Boisson'=>$recipesType6,'Confiserie'=>$recipesType7,'Sauce'=>$recipesType8);
  	
  	$searchCriteria = new SearchCriteria(); 	
	
  	$formSearchRecipe = $this->createForm(new SearchCriteriaType(), $searchCriteria);
  	
  	$data = array();
  	 
  	$formSearchIngredient = $this->createFormBuilder($data)
  	->add('test','hidden')
  	->add('search','submit')
  	->getForm();
  	
  	if ($formSearchRecipe->handleRequest($request)->isValid()) {
  		return $this->redirect($this->generateUrl('nz_platform_result', array('type' => 'keyWord' ,'dataForm' => $searchCriteria->getName())));
  	}
  	
  	if ($formSearchIngredient->handleRequest($request)->isValid()) {
		if(empty($formSearchIngredient->getData()['test'])){
			return $this->render('NZPlatformBundle:Recipe:index.html.twig', array('formSearchRecipe' => $formSearchRecipe->createView(),'formSearchIngredient' => $formSearchIngredient->createView(), 'recipes' => $recipes ));
		}
  		return $this->redirect($this->generateUrl('nz_platform_result',array('type' => 'ingredient' ,'dataForm' => $formSearchIngredient->getData()['test'] )));
  	}
  	
    return $this->render('NZPlatformBundle:Recipe:index.html.twig', array('formSearchRecipe' => $formSearchRecipe->createView(),'formSearchIngredient' => $formSearchIngredient->createView(), 'recipes' => $recipes ));
  }
  
  public function addAction(Request $request)
  {
  	$em = $this->getDoctrine()->getManager();
  	
  	$searchCriteria = new SearchCriteria();	
  	$formSearchRecipe = $this->createForm(new SearchCriteriaType(), $searchCriteria);
  	
  	$recipe = new Recipe(); 	
  	$formRecipe = $this->createForm(new RecipeType(), $recipe);
  	
  	if ($formSearchRecipe->handleRequest($request)->isValid()) {
  		return $this->redirect($this->generateUrl('nz_platform_result', array('type' => 'keyWord' ,'dataForm' => $searchCriteria->getName())));
  	}
  	
  	if ($formRecipe->handleRequest($request)->isValid()) {
  		$user  = $this->container->get('security.context')->getToken()->getUser();
  		$recipe->setViewsNumber(0);
  		$recipe->setUser($user);
  		$em->persist($recipe) ; 		
  		
  		$operations = $recipe->getOperations();
  		
  		if(count($operations)==0){
  			$recipe = $formRecipe->getData();
  			return $this->redirect($this->generateUrl('nz_platform_add', array('error_message' => 'une recette doit avoir au moins une operation')));
  		}
  		
  		$listIngredients = array(); $listIngredientsNames = array();
  		$listAppareils = array(); $listAppareilsNames = array();
  		$listUstensiles = array(); $listUstensilesNames = array();
  		$listActions = array(); $listActionsNames = array();
  		$hasIngredient = false;
  		
  		foreach ($operations as $operation){
  			
  			$etapes = $operation->getEtape();
  			
  			if(count($etapes)==0){
  				$recipe = $formRecipe->getData();
  				return $this->redirect($this->generateUrl('nz_platform_add', array('error_message' => 'une operation doit avoir au moins une étape')));
  			}
  			
  			foreach ($etapes as $etape){
  				
  				$ingredient = $etape->getIngredient();
  				$appareil = $etape->getAppareil();
  				$ustensile = $etape->getUstensile();
  				$action = $etape->getAction();
	  
  				if( $etape->getTypeEtape() == 'Ingredient' & $ingredient != null & $appareil == null & $ustensile == null & $action == null & $etape->getQuantity() !== null & $etape->getUmQuantity() != null & $etape->getPower() === null & $etape->getUmPower() == null & $etape->getTime() === null){
	  				
  					if( array_search($ingredient->getName(), $listIngredientsNames) !== false){$em->detach($ingredient);$etape->setIngredient($listIngredients[array_search($ingredient->getName(), $listIngredientsNames)]);}
  					else {$listIngredients[] = $ingredient; $listIngredientsNames[] = $ingredient->getName();}
  					
  					$repositoryIngredient = $em->getRepository('NZPlatformBundle:Ingredient');
	  				$ingredientFound = $repositoryIngredient->findOneBy(array('name' => $ingredient->getName()));
	  				
	  				if($ingredientFound != null){ $etape->setIngredient($ingredientFound); $em->detach($ingredient); }
	  				$hasIngredient = true;
  				} 				
  				elseif( $etape->getTypeEtape() == 'Appareil' &$ingredient == null & $appareil != null & $ustensile == null & $action == null & $etape->getQuantity() === null & $etape->getUmQuantity() == null & $etape->getPower() !== null & $etape->getUmPower() != null & $etape->getTime() === null){
  					
  					if( array_search($appareil->getName(), $listAppareilsNames) !== false){$em->detach($appareil);$etape->setAppareil($listAppareils[array_search($appareil->getName(), $listAppareilsNames)]);}
  					else {$listAppareils[] = $appareil; $listAppareilsNames[] = $appareil->getName();}
  					
  					$repositoryAppareil = $em->getRepository('NZPlatformBundle:Appareil');
  					$appareilFound = $repositoryAppareil->findOneBy(array('name' => $appareil->getName()));
  						
  					if($appareilFound != null){ $etape->setAppareil($appareilFound); $em->detach($appareil); }
  				} 				
  				elseif( $etape->getTypeEtape() == 'Ustensile' & $ingredient == null & $appareil == null & $ustensile != null & $action == null & $etape->getQuantity() === null & $etape->getUmQuantity() == null & $etape->getPower() === null & $etape->getUmPower() == null & $etape->getTime() === null){
  					
  					if( array_search($ustensile->getName(), $listUstensilesNames) !== false){$em->detach($ustensile);$etape->setUstensile($listUstensiles[array_search($ustensile->getName(), $listUstensilesNames)]);}
  					else {$listUstensiles[] = $ustensile; $listUstensilesNames[] = $ustensile->getName();}
  					
  					$repositoryUstensile = $em->getRepository('NZPlatformBundle:Ustensile');
  					$ustensileFound = $repositoryUstensile->findOneBy(array('name' => $ustensile->getName()));
  				
  					if($ustensileFound != null){ $etape->setUstensile($ustensileFound); $em->detach($ustensile); }
  				} 				
  				elseif($etape->getTypeEtape() == 'Action' & $ingredient == null & $appareil == null & $ustensile == null & $action != null & $etape->getQuantity() === null & $etape->getUmQuantity() == null & $etape->getPower() === null & $etape->getUmPower() == null ){
  					
  					if( array_search($action->getName(), $listActionsNames) !== false){$em->detach($action);$etape->setAction($listActions[array_search($action->getName(), $listActionsNames)]);}
  					else {$listActions[] = $action; $listActionsNames[] = $action->getName();}
  					
  					$repositoryAction = $em->getRepository('NZPlatformBundle:Action');
  					$actionFound = $repositoryAction->findOneBy(array('name' => $action->getName())); 					
  						
  					if($actionFound != null) { $etape->setAction($actionFound); $em->detach($action); }
  				}  				
  				else{
  					 $formRecipe = $this->createForm(new RecipeType(), $recipe);
  					 return $this->render('NZPlatformBundle:Recipe:add.html.twig', array('error_message' => 'remplissez correctement les champs associés à leurs étapes', 'formSearchRecipe' => $formSearchRecipe->createView(),'formRecipe' => $formRecipe->createView()));
  					 } 				
  			} 			
  		}
  		if($hasIngredient == false){$recipe = $formRecipe->getData();
  									return $this->redirect($this->generateUrl('nz_platform_add', array('error_message' => 'Une recette doit comporter au moins un ingredient')));}
  			
  		$recipe->setListIngredient(implode(",", $listIngredientsNames));
  		$em->flush();
  		$recipe = $formRecipe->getData();
  		return $this->redirect($this->generateUrl('nz_platform_view', array('id' => $recipe->getId())));
  	}
  	$recipe = $formRecipe->getData();
  	return $this->render('NZPlatformBundle:Recipe:add.html.twig', array('formSearchRecipe' => $formSearchRecipe->createView(),'formRecipe' => $formRecipe->createView()));
  }
  
  public function resultAction($type, $dataForm, $page, Request $request)
  {	
  	$nbPerPage = 20;
  	
  	$em = $this->getDoctrine()->getManager();
  	$recipeRepository = $em->getRepository('NZPlatformBundle:Recipe');
  	$searchCriteria = new SearchCriteria();	
  	$formSearchRecipe = $this->createForm(new SearchCriteriaType(), $searchCriteria);
  	$data = array();
  	$formSearchIngredient = $this->createFormBuilder($data)
  	->add('test','hidden')
  	->add('search','submit')
  	->getForm();

  	if($type == "keyWord"){$recipes = $recipeRepository->getRecipeWithKeywordPagined($dataForm, $page, $nbPerPage);
  						  $formSearchRecipe->get('name')->setData($dataForm);}
  	else {$recipes = $recipeRepository->getRecipeWithListIngredient($dataForm, $page, $nbPerPage);
  		  $formSearchIngredient->get('test')->setData($dataForm) ;}
  	
  	$nbPages = ceil(count($recipes)/$nbPerPage);
  	
  	if(count($recipes)==0){
  		return $this->redirect($this->generateUrl('nz_platform_home'));		
  	}
  	
  	if ($page > $nbPages) {
  		throw $this->createNotFoundException("La page ".$page." n'existe pas.");
  	}
  		  
  	if ($formSearchRecipe->handleRequest($request)->isValid()) {
  		$recipes = $recipeRepository->getRecipeWithKeywordPagined($searchCriteria->getName(), $page, $nbPerPage);
  		$formSearchIngredient->get('test')->setData(null) ;
  		$nbPages = ceil(count($recipes)/$nbPerPage);
  		
  		if ($page > $nbPages) {
  			throw $this->createNotFoundException("La page ".$page." n'existe pas.");
  		}
  		
  		return $this->render('NZPlatformBundle:Recipe:result.html.twig', array('formSearchRecipe' => $formSearchRecipe->createView(), 'formSearchIngredient' => $formSearchIngredient->createView(), 'type' => $type, 'dataForm' => $dataForm,  'recipes' => $recipes, 'page' => $page, 'nbPages'=> $nbPages));
  	} 	
		  
  	if ($formSearchIngredient->handleRequest($request)->isValid()) {
  		$recipes = $recipeRepository->getRecipeWithListIngredient($formSearchIngredient->getData()['test'], $page, $nbPerPage);
  		$formSearchRecipe->get('name')->setData(null);
  		
  		$nbPages = ceil(count($recipes)/$nbPerPage);
  		
  		if ($page > $nbPages) {
  			throw $this->createNotFoundException("La page ".$page." n'existe pas.");
  		}
  		
  		return $this->render('NZPlatformBundle:Recipe:result.html.twig', array('formSearchRecipe' => $formSearchRecipe->createView(), 'formSearchIngredient' => $formSearchIngredient->createView(), 'type' => $type, 'dataForm' => $dataForm, 'recipes' => $recipes, 'page' => $page, 'nbPages'=> $nbPages));
  	}	
  	
  	return $this->render('NZPlatformBundle:Recipe:result.html.twig', array( 'formSearchRecipe' => $formSearchRecipe->createView(), 'formSearchIngredient' => $formSearchIngredient->createView(), 'type' => $type, 'dataForm' => $dataForm, 'recipes' => $recipes, 'page' => $page, 'nbPages'=> $nbPages )); 	 
  }
  
  public function viewAction($id, Request $request)
  {
  	$searchCriteria = new SearchCriteria();
  	$formSearchRecipe = $this->createForm(new SearchCriteriaType(), $searchCriteria);
  	
  	$em = $this->getDoctrine()->getManager();
  	$recipe = $em->getRepository('NZPlatformBundle:Recipe')->find($id);
  	
  	if ($formSearchRecipe->handleRequest($request)->isValid()) {
  		return $this->redirect($this->generateUrl('nz_platform_result', array('type' => 'keyWord' ,'dataForm' => $searchCriteria->getName())));  		
  	}  	
  	return $this->render('NZPlatformBundle:Recipe:view.html.twig', array('formSearchRecipe' => $formSearchRecipe->createView(), 'recipe' => $recipe)); 	 
  }
  
  public function userRecipeAction($id, $page, Request $request)
  {  			
  	$nbPerPage = 20;
  	
  	$searchCriteria = new SearchCriteria();
  	$formSearchRecipe = $this->createForm(new SearchCriteriaType(), $searchCriteria);
  	
  	$em = $this->getDoctrine()->getManager();
  	
  	$recipeRepository = $em->getRepository('NZPlatformBundle:Recipe');
  	$recipes = $recipeRepository->getRecipeByUser($id, $page, $nbPerPage);
  	
  	if(count($recipes) == 0){
  		return $this->redirect($this->generateUrl('nz_platform_add'));
  	}

  	if ($formSearchRecipe->handleRequest($request)->isValid()) {
  		return $this->redirect($this->generateUrl('nz_platform_result', array('type' => 'keyWord' ,'dataForm' => $searchCriteria->getName())));
  	}
  	
  	$nbPages = ceil(count($recipes)/$nbPerPage);
  	if ($page > $nbPages) {
  		throw $this->createNotFoundException("La page ".$page." n'existe pas.");
  	}	 
  	
  	return $this->render('NZPlatformBundle:Recipe:user_recipe.html.twig', array('formSearchRecipe' => $formSearchRecipe->createView(), 'id' => $id, 'recipes' => $recipes, 'nbPages'=> $nbPages, 'page'=> $page));
  }
  
  public function deleteAction($id, Request $request)
  {
  	$em = $this->getDoctrine()->getManager();

  	$recipe = $em->getRepository('NZPlatformBundle:Recipe')->find($id);
  	
    if( !$this->isGranted("IS_AUTHENTICATED_REMEMBERED")
      ||  $this->container->get('security.context')->getToken()->getUser()->getId() != $recipe->getUser()->getId()){
      throw new AccessDeniedException("Accès interdit.");
    }

  	if (null === $recipe) {
  		throw new NotFoundHttpException("Cette recette n'existe pas.");
  	}
	
  	$searchCriteria = new SearchCriteria();
  	$formSearchRecipe = $this->createForm(new SearchCriteriaType(), $searchCriteria);
  	$form = $this->createFormBuilder()->getForm();
  	
  	if ($form->handleRequest($request)->isValid()) {
  		$em->remove($recipe);
  		$em->flush();
  	
  		$request->getSession()->getFlashBag()->add('info', "La recette a bien été supprimée.");
  	
  		return $this->redirect($this->generateUrl('nz_platform_home'));
  	}
  	return $this->render('NZPlatformBundle:Recipe:delete.html.twig', array('recipe' => $recipe, 'formSearchRecipe' => $formSearchRecipe->createView(), 'form' => $form->createView()));
  }
  
  public function editAction($id, Request $request)
  {
  	$em = $this->getDoctrine()->getManager();
	
  	$recipe = $em->getRepository('NZPlatformBundle:Recipe')->find($id);

    if( !$this->isGranted("IS_AUTHENTICATED_REMEMBERED")
      ||  $this->container->get('security.context')->getToken()->getUser()->getId() != $recipe->getUser()->getId()){
      throw new AccessDeniedException("Accès interdit.");
    }
    
  	if (null === $recipe) {
  		throw new NotFoundHttpException("La recette n'existe pas.");
  	}
  	$searchCriteria = new SearchCriteria();
  	$formSearchRecipe = $this->createForm(new SearchCriteriaType(), $searchCriteria);
  	
  	if ($formSearchRecipe->handleRequest($request)->isValid()) {
  		return $this->redirect($this->generateUrl('nz_platform_result', array('type' => 'keyWord' ,'dataForm' => $searchCriteria->getName())));
  	}
  	
  	$formRecipe = $this->createForm(new RecipeType(), $recipe);
  	$em->remove($recipe);
  	if ($formRecipe->handleRequest($request)->isValid()) {
  		
  		$em->persist($recipe);
  		
  		if(count($recipe->getOperations())==0){
  			$recipe = $formRecipe->getData();
  			return $this->redirect($this->generateUrl('nz_platform_edit', array('error_message' => 'une recette doit avoir au moins une operation')));
  		}
  		
  		$listIngredients = array(); $listIngredientsNames = array();
  		$listAppareils = array(); $listAppareilsNames = array();
  		$listUstensiles = array(); $listUstensilesNames = array();
  		$listActions = array(); $listActionsNames = array();
  		$hasIngredient = false;
  		
  		foreach($recipe->getOperations() as $operation){
  			
  			if(count($operation->getEtape())==0){
  				$recipe = $formRecipe->getData();
  				return $this->redirect($this->generateUrl('nz_platform_edit', array('error_message' => 'une operation doit avoir au moins une étape')));
  			}
  			
  			foreach($operation->getEtape() as $etape){ 

		  			$ingredient = $etape->getIngredient();
		  			$appareil = $etape->getAppareil();
		  			$ustensile = $etape->getUstensile();
		  			$action = $etape->getAction();
		  			 
		  			if( $etape->getTypeEtape() == 'Ingredient' & $ingredient != null & $appareil == null & $ustensile == null & $action == null & $etape->getQuantity() != null & $etape->getUmQuantity() != null & $etape->getPower() == null & $etape->getUmPower() == null & $etape->getTime() == null){
		  					
		  				if( array_search($ingredient->getName(), $listIngredientsNames) !== false){$em->detach($ingredient);$etape->setIngredient($listIngredients[array_search($ingredient->getName(), $listIngredientsNames)]);}
		  				else {$listIngredients[] = $ingredient; $listIngredientsNames[] = $ingredient->getName();}
		  					
		  				$repositoryIngredient = $em->getRepository('NZPlatformBundle:Ingredient');
		  				$ingredientFound = $repositoryIngredient->findOneBy(array('name' => $ingredient->getName()));
		  					
		  				if($ingredientFound != null){ $etape->setIngredient($ingredientFound); $em->detach($ingredient); }
		  				$hasIngredient = true;
		  			}
		  			elseif( $etape->getTypeEtape() == 'Appareil' & $ingredient == null & $appareil != null & $ustensile == null & $action == null & $etape->getQuantity() == null & $etape->getUmQuantity() == null & $etape->getPower() != null & $etape->getUmPower() != null & $etape->getTime() == null){
		  					
		  				if( array_search($appareil->getName(), $listAppareilsNames) !== false){$em->detach($appareil);$etape->setAppareil($listAppareils[array_search($appareil->getName(), $listAppareilsNames)]);}
		  				else {$listAppareils[] = $appareil; $listAppareilsNames[] = $appareil->getName();}
		  					
		  				$repositoryAppareil = $em->getRepository('NZPlatformBundle:Appareil');
		  				$appareilFound = $repositoryAppareil->findOneBy(array('name' => $appareil->getName()));
		  			
		  				if($appareilFound != null){ $etape->setAppareil($appareilFound); $em->detach($appareil); }
		  			}
		  			elseif( $etape->getTypeEtape() == 'Ustensile' & $ingredient == null & $appareil == null & $ustensile != null & $action == null & $etape->getQuantity() == null & $etape->getUmQuantity() == null & $etape->getPower() == null & $etape->getUmPower() == null & $etape->getTime() == null){
		  					
		  				if( array_search($ustensile->getName(), $listUstensilesNames) !== false){$em->detach($ustensile);$etape->setUstensile($listUstensiles[array_search($ustensile->getName(), $listUstensilesNames)]);}
		  				else {$listUstensiles[] = $ustensile; $listUstensilesNames[] = $ustensile->getName();}
		  					
		  				$repositoryUstensile = $em->getRepository('NZPlatformBundle:Ustensile');
		  				$ustensileFound = $repositoryUstensile->findOneBy(array('name' => $ustensile->getName()));
		  			
		  				if($ustensileFound != null){ $etape->setUstensile($ustensileFound); $em->detach($ustensile); }
		  			}
		  			elseif($etape->getTypeEtape() == 'Action' & $ingredient == null & $appareil == null & $ustensile == null & $action != null & $etape->getQuantity() == null & $etape->getUmQuantity() == null & $etape->getPower() == null & $etape->getUmPower() == null ){
		  					
		  				if( array_search($action->getName(), $listActionsNames) !== false){$em->detach($action);$etape->setAction($listActions[array_search($action->getName(), $listActionsNames)]);}
		  				else {$listActions[] = $action; $listActionsNames[] = $action->getName();}
		  					
		  				$repositoryAction = $em->getRepository('NZPlatformBundle:Action');
		  				$actionFound = $repositoryAction->findOneBy(array('name' => $action->getName()));
		  			
		  				if($actionFound != null) { $etape->setAction($actionFound); $em->detach($action); }
		  			}
		  			else{
  					 	return $this->redirect($this->generateUrl('nz_platform_edit', array('error_message' => 'remplissez correctement les champs associés à leurs étapes', 'id' => $recipe->getId())));
		  			}	  				
	  		}
  		}
  		
  		if($hasIngredient == false){
  			$recipe = $formRecipe->getData();
  			return $this->redirect($this->generateUrl('nz_platform_edit', array('error_message' => 'Une recette doit comporter au moins un ingredient', 'id' => $recipe->getId())));
  		}
  			
  		$recipe->setListIngredient(implode(",", $listIngredientsNames));
  		$em->flush();
  			
  		$request->getSession()->getFlashBag()->add('notice', 'Recette bien modifiée.');
  	
  		return $this->redirect($this->generateUrl('nz_platform_view', array('id' => $recipe->getId())));
  	}
  	return $this->render('NZPlatformBundle:Recipe:edit.html.twig', array('formSearchRecipe' => $formSearchRecipe->createView(), 'formRecipe' => $formRecipe->createView(), 'recipe' => $recipe  ));
  }
  
  public function aboutAction(Request $request)
  {
  	$searchCriteria = new SearchCriteria();
  	$formSearchRecipe = $this->createForm(new SearchCriteriaType(), $searchCriteria);
  	
  	if ($formSearchRecipe->handleRequest($request)->isValid()) {
  		return $this->redirect($this->generateUrl('nz_platform_result', array('type' => 'keyWord' ,'dataForm' => $searchCriteria->getName())));
  	}
  	
  	return $this->render('NZPlatformBundle:Recipe:about.html.twig', array('formSearchRecipe' => $formSearchRecipe->createView())); 	 
  }
  
  public function termsAction(Request $request)
  {
  	$searchCriteria = new SearchCriteria();
  	$formSearchRecipe = $this->createForm(new SearchCriteriaType(), $searchCriteria);
  	
  	if ($formSearchRecipe->handleRequest($request)->isValid()) {
  		return $this->redirect($this->generateUrl('nz_platform_result', array('type' => 'keyWord' ,'dataForm' => $searchCriteria->getName())));
  	}
  	
  	return $this->render('NZPlatformBundle:Recipe:terms.html.twig', array('formSearchRecipe' => $formSearchRecipe->createView()));	 
  }
}