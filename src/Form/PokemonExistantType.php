<?php

namespace App\Form;

use App\Entity\PokemonExistant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PokemonExistantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sexe')
            ->add('xp')
            ->add('niveau')
            ->add('prix')
            ->add('pokemonType')
            ->add('dresseur')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PokemonExistant::class,
        ]);
    }
}
