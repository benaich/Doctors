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
        $builder
            ->add('name', 'text', array('label'=>'Motif'))
            ->add('type', 'choice', array('label'=>'Type', 'choices' => array(
                    'Examens général' => 'Examens général',
                    'Examens biologiques' => 'Examens biologiques',
                    'Examens radioloqiue' => 'Examens radioloqiue',
                    'Autre' => 'Autre')))
            ->add('consultation')
            ->add('request', 'textarea', array('label'=>'Demande'))
            ->add('result', 'textarea', array('label'=>'Resultat'))
            ;

        if($this->general)
            $builder
                ->add('taille', 'text', array('label'=>'Taille'))
                ->add('poids', 'text', array('label'=>'Poids'))
                ->add('ta', 'text', array('label'=>'TA'))
                ->add('od', 'text', array('label'=>'OD'))
                ->add('og', 'text', array('label'=>'OG'))
                ->add('symptomes', 'textarea', array('label'=>'Symptomes'))
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
