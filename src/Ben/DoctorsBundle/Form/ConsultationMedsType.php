<?php

namespace Ben\DoctorsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ConsultationMedsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('meds', 'entity', array('label'=>'Medicament', 'class' => 'BenDoctorsBundle:Meds','property' => 'name',))
            ->add('count','text', array('label'=>'Nombre d\'unité'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ben\DoctorsBundle\Entity\ConsultationMeds'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ben_consultationmeds';
    }
}
