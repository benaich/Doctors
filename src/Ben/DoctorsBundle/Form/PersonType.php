<?php

namespace Ben\DoctorsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PersonType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cin')
            ->add('cne')
            ->add('firstname')
            ->add('familyname')
            ->add('email')
            ->add('birthday', 'date', array('widget' => 'single_text'))
            ->add('birthcity')
            ->add('gender', 'choice', array('choices' => array('Féminin' => 'Féminin','Masculin' => 'Masculin'),
                    'required' => false,))
            ->add('contry')
            ->add('city')
            ->add('resident', 'checkbox', array('required' => false,))
            ->add('address')
            ->add('etablissement')
            ->add('university')
            ->add('gsm')
            // ->add('cnss')
            ->add('cnsstype', 'choice', array('choices' => array('Ramed' => 'Ramed','Cnops' => 'Cnops','Cnss' => 'Cnss','Assurance privé' => 'Assurance privé','sans' => 'sans')))
            ->add('parentName')
            ->add('parentAddress')
            ->add('parentGsm')
            ->add('parentFixe')
            ->add('ishandicap', 'checkbox', array('required' => false,))
            ->add('handicap')
            ->add('needs')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ben\DoctorsBundle\Entity\Person'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ben_person';
    }
}
