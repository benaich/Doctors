<?php

namespace Ben\DoctorsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AntecedentType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('allergies')
            ->add('autres')
            ->add('traitement')
            ->add('chirurgicaux')
            ->add('type', 'choice', array('choices' => array('Antecedents personnels' => 'Antecedents personnels','Antecedents familiaux' => 'Antecedents familiaux')))
            ->add('person')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ben\DoctorsBundle\Entity\Antecedent'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ben_antecedent';
    }
}
