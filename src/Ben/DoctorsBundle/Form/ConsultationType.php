<?php

namespace Ben\DoctorsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Ben\DoctorsBundle\Entity\Consultation;

class ConsultationType extends AbstractType
{
    private $general;
    public function __construct($type)
    {
        $this->general = ($type === Consultation::$GENERAL);
    }
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if($this->general)
            $builder
                ->add('motiftype', 'choice', array('label'=>'Type', 'choices' => array('EXAMEN MEDICAL SYSTEMATIQUE' => 'EXAMEN MEDICAL SYSTEMATIQUE','CONSULTATION MEDICALE A LA DEMANDE' => 'CONSULTATION MEDICALE A LA DEMANDE'),
                    'required' => false,))
                ->add('name', 'text', array('label'=>'Motif'));
        else
            $builder
                ->add('name', 'text', array('label'=>'Specialité medicale'))
                ->add('infrastructure', 'text', array('label'=>'Infrastructure sanitaire de reference'));

        $builder
            ->add('diagnosis')
            ->add('treatment', 'textarea', array('label'=>'Traitement préscrit', 'required'  => false))
            ->add('person')
            ->add('type', 'hidden');


        if($this->general)
            $builder
                ->add('decision', 'choice', array('label'=>'Décision prise', 'choices' => array(
                            'Préscription du traitement' => 'Préscription du traitement',
                            'Orientation vers la consultation médicale spécialisé' => 'Orientation vers la consultation médicale spécialisé'),
                    'required' => false,))
                ->add('chronic', 'checkbox', array('label'=>'Maladie chronique ?', 'required'  => false));

        $builder->add('consultationmeds', 'collection', array('label'=>'Medicaments déliverés par le centre', 'type' => new ConsultationMedsType(), 'allow_add' => true, 'by_reference' => false, 'allow_delete' => true,'prototype' => true,))
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
