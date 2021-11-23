<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class,[
                'label'=>'Quel nom souhaitez-vous donner à votre adresse ?',
                'required'=>true,
                'attr'=>[
                    'placeholder'=>'Nommez votre adresse'
                ]
            ])
            ->add('firstname',TextType::class,[
                'label'=>'Votre Nom',
                'attr'=>[
                    'placeholder'=>'ici votre nom'
                ]
            ])
            ->add('lastname',TextType::class,[
                'label'=>'Votre Prénom',
                'attr'=>[
                    'placeholder'=>'ici votre prénom'
                ]
            ])
            ->add('comapny',TextType::class,[
                'label'=>'Votre Société',
                'required'=>false,
                'attr'=>[
                    'placeholder'=>'(facultatif) ici votre société'
                ]
            ])

            ->add('address',TextType::class,[
                'label'=>'votre adresse',
                'attr'=>[
                    'placeholder'=>'exemple : 1 rue Abdoulaye NDIAYE ...'
                ]
            ])
            ->add('postal',TextType::class,[
                'label'=>'Votre Code Posyal',
                'attr'=>[
                    'placeholder'=>'ici votre code postal'
                ]
            ])
            ->add('city',TextType::class,[
                'label'=>'Ville',
                'attr'=>[
                    'placeholder'=>'ici votre ville'
                ]
            ])
            ->add('country',CountryType::class,[
                'label'=>'Pays'
            ])

            ->add('phone',TextType::class,[
                'label'=>'Votre Téléphone',
                'attr'=>[
                    'placeholder'=>'ici votre phone'
                ]
            ])
            ->add('submit',SubmitType::class,[
                'label'=>'Ajouter mon adresse',
                'attr'=>[
                    'class'=>'btn btn-outline-info float-end'
    ]
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
