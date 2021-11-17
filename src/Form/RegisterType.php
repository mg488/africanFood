<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname',TextType::class,[
                'label'=>'Prénom',
                'constraints'=> new Length([
                    'min'=>2,
                    'max'=>30]),
                'attr' =>[
                    'placeholder'=>'merci de saisir votre prénom'
                ]
            ])
            ->add('lastname', TextType::class,[
                'label'=>'Nom',
                'constraints'=> new Length([
                    'min'=>2,
                    'max'=>30]),
                'attr'=>[
                    'placeholder'=>'merci de saisir votre nom'
                ]
            ])
            ->add('email',EmailType::class,[
                'label'=>'Email',
                'constraints'=> new Length([
                    'min'=>2,
                    'max'=>60]),
                'attr'=>[
                    'placeholder'=>'merci de saisir votre email'
                ]
            ])
            ->add('password',RepeatedType::class,[
                'type'=> PasswordType::class,
                'invalid_message'=>'mot de passe non conforme',
                'required'=>true,
                'first_options'=>['label'=>'Mot de passe',
                                  'attr'=>[
                                      'placeholder'=>'Saisir votre mot de passe']
                                    ],
                'second_options'=>['label'=>'Confirmez Votre Mot de passe',
                                'attr'=>[
                                    'placeholder'=>'Confirmez votre mot de passe']
                                    ],
                'attr'=>[
                    'placeholder'=>'merci de saisir un mot de passe',
                ]
            ])

            ->add('submit',SubmitType::class,[
                'label'=>'Valider'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}