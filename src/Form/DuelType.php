<?php

namespace App\Form;

use App\Entity\Duel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DuelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('winst')
            ->add('ronde')
            ->add('score')
            ->add('deelnemer')
            ->add('wedstrijd')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Duel::class,
        ]);
    }
}
