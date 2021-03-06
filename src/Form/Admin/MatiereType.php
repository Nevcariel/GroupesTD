<?php

namespace App\Form\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Matiere;
use App\Entity\Enseignant;


class MatiereType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('intitule', TextType::class, array(
            'label' => 'Intitulé de la matière*',
        ));
        $builder->add('description', TextareaType::class, array(
            'label' => 'Description*',
        ));
        $builder->add('enseignants', EntityType::class,
            array(
                'label' => 'Enseignant(s)',
                'class' => Enseignant::class,
                'multiple' => true,
                'expanded' => true
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Matiere::class,
        ));
    }
}