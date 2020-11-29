<?php

namespace NZ\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use NZ\PlatformBundle\Entity\Video;

class RecipeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {	
        $builder
	        ->add('name','text',array('attr' => array('class' => 'name_recipe')))
	        ->add('time','integer',array('attr' => array('class' => 'time_recipe')))
	        ->add('type','choice', array('placeholder' => 'type',
        									  'choices' => array('Entrée' => 'Entrée','Plat principal' => 'Plat principal','Dessert' => 'Dessert','Accompagnement' => 'Accompagnement','Amuse-gueule' => 'Amuse-gueule','Boisson' => 'Boisson','Confiserie' => 'Confiserie','Sauce' => 'Sauce'),
        									  'attr' => array('class' => 'type'),))
        	->add('person_number','integer',array('attr' => array('class' => 'number_person_recipe')))       	
	        ->add('difficult','choice', array('placeholder' => 'difficulté',
        									  'choices' => array('Très facile' => 'Très facile','Facile' => 'Facile','Moyenne' => 'Moyenne','Difficile' => 'Difficile'),
        									  'attr' => array('class' => 'difficult_recipe'),)) 
        	->add('description','textarea', array('attr' => array('class' => 'description_recipe')))
	        ->add('video',new VideoType(), array('required' => false))
	        ->add('picture', new PictureType())
        	->add('operations', 'collection', array(
    			'type'           => new OperationType(),
    			'label'          => 'Add, move, remove operations',
    			'allow_add'      => true,
    			'allow_delete'   => true,
        		'by_reference'	 => false,
    			'prototype'      => true,
    			'prototype_name' => '__parent_name__',
    			'attr'           => array('class' => "parent-collection",    			
    			),
    		))
    		->add('save', 'submit')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'NZ\PlatformBundle\Entity\Recipe'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'nz_platformbundle_recipe';
    }
}
