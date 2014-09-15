<?php

namespace Ben\DoctorsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MedsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name','text', array('label'=>'Medicament'))
            ->add('count','text', array('label'=>'Nombre d\'unité'))
            ->add('type','text', array('label'=>'Type'))
            ->add('about','textarea', array('label'=>'Description'))
            ->add('expdate','date', array('widget' => 'single_text', 'label'=>'Date d\'expiration'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ben\DoctorsBundle\Entity\Meds'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ben_meds';
    }
}
