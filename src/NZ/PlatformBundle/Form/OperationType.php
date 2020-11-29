<?php

namespace NZ\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use NZ\PlatformBundle\Entity\Etape;

class OperationType  extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('etape', 'collection', array(
        		'type'           => new EtapeType(),
        		'label'          => 'Add, move, remove etapes',
        		'allow_add'      => true,
        		'allow_delete'   => true,
        		'by_reference'	 => false,
        		'prototype'      => true,
        		'prototype_name' => '__children_name__',
        		'attr'           => array('class' => "child-collection"),       						          
        ))
            ->add('description', 'textarea', array('required' => false,
            									   'attr'=> array('class' => "operation_textarea col-md-5",
            													  'placeholder' => '  Description ( Facultatif )',)))
            ->add('gif', new GifType(), array('required' => false,
						               'attr'=> array('class' => "input-gif",
            				                          'accept' => 'gif/*',)))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'NZ\PlatformBundle\Entity\Operation'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'OperationType';
    }
}
