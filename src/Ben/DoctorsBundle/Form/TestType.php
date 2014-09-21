<?php

namespace Ben\DoctorsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TestType extends AbstractType
{
    private $general;
    public function __construct($general = false)
    {
        $this->general = $general;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('consultation');

        if($this->general)
            $builder
                ->add('taille', 'text', array('label'=>'Taille'))
                ->add('poids', 'text', array('label'=>'Poids'))
                ->add('ta', 'text', array('label'=>'TA'))
                ->add('od', 'text', array('label'=>'OD'))
                ->add('og', 'text', array('label'=>'OG'))
                ->add('hasvisualissue', 'checkbox', array('label'=>'Trouble visuel','required'  => false))
                ->add('fixedvisualissue', 'choice', array('choices' => ['Corrigé'=>'Corrigé', 'Non corrigé'=>'Non corrigé'], 
                        'expanded' => true,
                        'multiple' => false,
                        'label' => false,
                        ))
                ;
        else 
            $builder
                ->add('type', 'choice', array('label'=>'Type', 'choices' => array(
                    'Examens biologiques' => 'Examens biologiques',
                    'Examens radioloqiue' => 'Examens radioloqiue',
                    'Autre' => 'Autre')))
                ->add('request', 'textarea', array('label'=>'Demande','required'  => false))
                ->add('result', 'textarea', array('label'=>'Resultat','required'  => false))
                ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ben\DoctorsBundle\Entity\Test'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ben_test';
    }
}
