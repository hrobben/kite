<?php

namespace App\Form;

use App\Entity\Deelnemer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DeelnemerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('first_name')
            ->add('insertion_name')
            ->add('last_name')
            ->add('adress')
            ->add('zip')
            ->add('city')
            ->add('verzekering')
            ->add('tel_nr')
            ->add('mobile_nr')
            ->add('userid')
            ->add('categorieid')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Deelnemer::class,
        ]);
    }
}
