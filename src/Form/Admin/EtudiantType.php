<?php

namespace App\Form\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Etudiant;
use App\Entity\Promotion;
use App\Entity\Bac;
use App\Entity\Groupe;


class EtudiantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('codeNip', TextType::class, array(
            'label' => 'Code NIP*',
        ));
        $builder->add('nom', TextType::class, array(
            'label' => 'Nom*',
        ));
        $builder->add('prenom', TextType::class, array(
            'label' => 'Prénom*',
        ));
        $builder->add('username', TextType::class, array(
            'label' => 'Identifiant*',
        ));
        $builder->add('classement', TextType::class, array(
            'required' => false,
        ));
        $builder->add('moyenne', NumberType::class, array(
            'required' => false,
            'scale' => 2,
        ));
        $builder->add('promotion', EntityType::class, array(
            'label' => 'Promotion*',
            'class' => Promotion::class,
            'expanded' => true,
        ));
        $builder->add('bac', EntityType::class, array(
            'class' => Bac::class,
            'expanded' => true,
        ));
        $builder->add('groupe', EntityType::class, array(
            'class' => Groupe::class,
            'placeholder' => 'select',
            'required' => false,
        ));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Etudiant::class,
        ));
    }
}