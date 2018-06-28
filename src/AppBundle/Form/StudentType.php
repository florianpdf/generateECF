<?php

namespace AppBundle\Form;

use AppBundle\Entity\Student;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudentType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('firstname')
            ->add('dateOfBirth')
            ->add('campus')
            ->add('validateActivityOne')
            ->add('commActivityOne')
            ->add('validateEvalSuppOne')
            ->add('commEvalSuppOne')
            ->add('validateActivityTwo')
            ->add('commActivityTwo')
            ->add('validateEvalSuppTwo')
            ->add('commEvalSuppTwo')
            ->add('observationStudent')
            ->add('gender', ChoiceType::class, array(
                'choices' => array(
                    'Homme' => Student::MALE,
                    'Femme'=> Student::FEMALE
                )
            ))
        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Student'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_student';
    }


}
