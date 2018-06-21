<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Entity\Enseignant;


class EnseignantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom', TextType::class, array(
            'label' => 'Nom*'
        ));
        $builder->add('prenom', TextType::class, array(
            'label' => 'Prénom*'
        ));
        $builder->add('entreprise', TextType::class, array(
            'required' => false,
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Enseignant::class,
        ));
    }
}