<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Userprofile;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('bio')
            ->add('website_url')
            ->add('twitter_username')
            ->add('company')
            ->add('location')
            ->add('date_of_birth', null, [
                'widget' => 'single_text',
            ])
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Userprofile::class,
        ]);
    }
}
