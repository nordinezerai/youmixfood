<?php

namespace NZ\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use NZ\PlatformBundle\Entity\TypeEtape;

class EtapeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        	->add('typeEtape','choice', array('placeholder' => 'Choisissez une étape',
        									  'choices' => array('Ingredient' => 'Ingredient','Appareil' => 'Appareil','Ustensile' => 'Ustensile','Action' => 'Action'),
        									  'attr' => array('class' => 'select'),
        	))
            ->add('ingredient', new IngredientType(), array('required' => false,)) 
            ->add('appareil', new AppareilType(), array('required' => false,))
            ->add('action', new ActionType(), array('required' => false,))
            ->add('ustensile', new UstensileType(), array('required' => false,))
            ->add('quantity' ,'integer')
            ->add('power' ,'integer')
            ->add('time' ,'integer')
            ->add('um_quantity','choice', array('placeholder' => 'mesure',
            									'choices' => array('unité' => 'unité', 'mg' => 'mg', 'g' => 'g', 'kg' => 'kg', 'mL' => 'mL', 'L' => 'L')))
            ->add('um_power','choice', array('placeholder' => 'mesure',
            								 'choices' => array('°C' => '°C', 'W' => 'W', 'trs/min' => 'trs/min')))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'NZ\PlatformBundle\Entity\Etape'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'EtapeType';
    }
}
