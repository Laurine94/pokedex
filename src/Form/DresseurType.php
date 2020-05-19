<?php

namespace App\Form;

use App\Entity\Dresseur;
use App\Entity\PokemonType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class DresseurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $em = $options['entity_manager'];
        $starters = $em->getRepository(PokemonType::class)
                        ->getStarter();
            $choices =[];
            foreach ($starters as $poke){
                $choices[$poke->getNom()] = $poke;
            }

        $builder
            ->add('email', EmailType::class)
            //->add('password',PasswordType::class)
            ->add('pseudo',TextType::class)
            ->add('starter',ChoiceType::class,array(
                'choices' => $choices,
              ))

        ;
    }
 

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('entity_manager');
        $resolver->setDefaults([
            'data_class' => Dresseur::class,
        ]);
    }
}
