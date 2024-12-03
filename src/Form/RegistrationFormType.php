<?php

namespace App\Form;

use App\Entity\User;
use App\Form\UserProfileType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter an email address.',
                    ]),
                    new Email([
                        'message' => 'Please enter a valid email address.',
                    ]),
                ],
            ])
            
            ->add('plainPassword', RepeatedType::class, [
               
                'type' => PasswordType::class,
                'mapped' => false,
                'invalid_message'=>'The password fields must match',
                'attr' => ['autocomplete' => 'new-password'],
                'first_options'=>[
                    'label' => 'password',
                    'mapped'=>false

                ],
                'second_options'=>[
                    'label' => ' Confirm password',
                    'mapped'=>false

                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                      
                        'max' => 4096,
                    ]),
                ],
            ])

            ->add('Userprofile',UserProfileType::class);
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token', 
        ]);
    }
}
