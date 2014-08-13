<?php

namespace Ben\DoctorsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ConsultationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('diagnosis')
            ->add('treatment')
            ->add('person')
            ->add('consultationmeds', 'collection', array('type' => new ConsultationMedsType(), 'allow_add' => true, 'by_reference' => false, 'allow_delete' => true,'prototype' => true,))
            
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ben\DoctorsBundle\Entity\Consultation'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ben_consultation';
    }
}
