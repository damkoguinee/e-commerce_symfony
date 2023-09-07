<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username')
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter les C.G.U.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'le mot de passe doit contenir au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])

            ->add('prenom',null,[
                "constraints"   =>  [
                    new Length([
                        "max"           =>  20,
                        "maxMessage"    =>  "Le prénom ne doit pas contenir plus de 20 caractères",
                        "min"           =>  4,
                        "minMessage"    =>"Le prénom ne doit pas contenir moins de 4 caractères"
                    ])
                ],
                "attr"  =>["placeholder" =>"Prénom"]
            ])

            ->add('nom', null, [
                "constraints"   =>  [
                    new Length([
                        "max"           =>  30,
                        "maxMessage"    =>  "Le prénom ne doit pas contenir plus de 30 caractères",
                        
                    ]),
                    new NotBlank(["message" => "le nom ne peut pas être vide !"])
                ],
                "required"  =>false,
                "label"     =>"Nom*"
            ])
            ->add('telephone', null, [
                "constraints"   =>  [
                    new Length([
                        "min"           =>  8,
                        "minMessage"    =>  "Le téléphone ne doit pas contenir moins de 8 ",
                        
                    ]),
                    new NotBlank(["message" => "le téléphone ne peut pas être vide !"])
                ],
                "label"     =>"Téléphone*"
            ])

            ->add('email', null, [
                "constraints"   =>  [
                    new Length([
                        "max"           =>  100,
                        "maxMessage"    =>  "L'email ne doit pas contenir plus de 100 caractères",
                        
                    ])
                ],
                "required"  =>false,
                "label"     =>"Email"
            ])

            ->add('naissance', DateType::class, [
                "widget"    =>  "single_text",
                "required"  =>  false,
                "label"     => "Date de naissance"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
