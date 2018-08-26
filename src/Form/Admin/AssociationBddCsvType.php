<?php

namespace App\Form\Admin;

use App\Entity\AssociationBddCsv;
use App\Entity\ChampBDD;
use App\Entity\ChampCsv;
use App\Form\Admin\ChampCsvType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class AssociationBddCsvType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('champBdd', EntityType::class,[
                'class' => ChampBDD::class,
                'label' => 'Nom du champ dans la base de données',
            ])
            ->add('champCsv', ChampCsvType::class, [
                'label' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AssociationBddCsv::class,
        ]);
    }
}
