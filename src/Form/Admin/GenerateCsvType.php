<?php

namespace App\Form\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Csv;
use App\Entity\Promotion;
use App\Entity\TypeCsv;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class GenerateCsvType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('promotion', EntityType::class, array(
            'class' => Promotion::class,
            'label' => 'Selectionnez la promotion',
        ));
        $builder->add('typeCsv', EntityType::class, [
            'class' => TypeCsv::class,
            'label' => 'Selectionnez le type de csv'
        ]);
        $builder->add('save', SubmitType::class, array('label' => 'Suivant'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Csv::class,
        ));
    }
}