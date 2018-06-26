<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Matiere;
use App\Entity\Etudiant;


class VoeuxType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('voeuPrincipal', EntityType::class, array(
            'label' => 'Voeu principal :',
            'class' => Matiere::class,
            'expanded' => true,

        ));
        $builder->add('voeuSecondaire', EntityType::class, array(
            'label' => 'Voeu secondaire :',
            'class' => Matiere::class,
            'expanded' => true,
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Etudiant::class,
        ));
    }
}