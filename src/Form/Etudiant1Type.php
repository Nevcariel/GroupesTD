<?php

namespace App\Form;

use App\Entity\Etudiant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Etudiant1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codeNip')
            ->add('nom')
            ->add('prenom')
            ->add('classement')
            ->add('username')
            ->add('moyenne')
            ->add('promotion')
            ->add('bac')
            ->add('groupe')
            ->add('voeuPrincipal')
            ->add('voeuSecondaire')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Etudiant::class,
        ]);
    }
}
