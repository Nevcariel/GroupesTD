<?php

namespace App\Form\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use App\Entity\Csv;
use App\Entity\Promotion;
use App\Entity\TypeCsv;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class CsvType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('file', FileType::class, array('label' => 'Fichier (.csv)'));
        $builder->add('typeCsv', EntityType::class, [
            'class' => TypeCsv::class,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Csv::class,
        ));
    }
}