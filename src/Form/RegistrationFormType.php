<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Email;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // === Civilité ===
            ->add('civility', ChoiceType::class, [
                'label' => 'Civilité',
                'choices' => [
                    'Monsieur' => 'Monsieur',
                    'Madame' => 'Madame',
                ],
                'expanded' => true,
                'multiple' => false,
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez sélectionner votre civilité.']),
                ],
            ])

            // === Nom ===
            ->add('lastName', TextType::class, [
                'label' => 'Nom',
                'attr' => ['placeholder' => 'Votre nom'],
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez renseigner votre nom.']),
                    new Length(['min' => 2, 'max' => 100, 'minMessage' => 'Le nom doit contenir au moins {{ limit }} caractères.']),
                    new Regex([
                        'pattern' => '/^[A-Za-zÀ-ÿ\s\'-]+$/u',
                        'message' => 'Le nom ne peut contenir que des lettres, des espaces ou des tirets.',
                    ]),
                ],
            ])

            // === Prénom ===
            ->add('firstName', TextType::class, [
                'label' => 'Prénom',
                'attr' => ['placeholder' => 'Votre prénom'],
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez renseigner votre prénom.']),
                    new Length(['min' => 2, 'max' => 100, 'minMessage' => 'Le prénom doit contenir au moins {{ limit }} caractères.']),
                    new Regex([
                        'pattern' => '/^[A-Za-zÀ-ÿ\s\'-]+$/u',
                        'message' => 'Le prénom ne peut contenir que des lettres, des espaces ou des tirets.',
                    ]),
                ],
            ])

            // === Adresse ===
            ->add('address', TextType::class, [
                'label' => 'Adresse',
                'attr' => ['placeholder' => 'N°, rue'],
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez indiquer votre adresse.']),
                    new Length(['min' => 5, 'max' => 255]),
                ],
            ])

            // === Complément d'adresse (facultatif) ===
            ->add('addressComplement', TextType::class, [
                'label' => 'Complément d\'adresse',
                'required' => false,
                'attr' => ['placeholder' => 'Votre complément d\'adresse'],
                'help' => 'Exemple : N° d\'appartement, étage, couloir, escalier…',
            ])

            // === Ville ===
            ->add('city', TextType::class, [
                'label' => 'Ville ou Commune',
                'attr' => ['placeholder' => 'Votre ville ou commune'],
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez indiquer votre ville.']),
                    new Regex([
                        'pattern' => '/^[A-Za-zÀ-ÿ\s\'-]+$/u',
                        'message' => 'La ville ne peut contenir que des lettres et des espaces.',
                    ]),
                ],
            ])

            // === Code postal ===
            ->add('zipcode', TextType::class, [
                'label' => 'Code postal',
                'attr' => ['placeholder' => '29300'],
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez indiquer votre code postal.']),
                    new Regex([
                        'pattern' => '/^[0-9]{5}$/',
                        'message' => 'Le code postal doit contenir exactement 5 chiffres.',
                    ]),
                ],
            ])

            // === Téléphone ===
            ->add('phone', TelType::class, [
                'label' => 'Téléphone',
                'attr' => ['placeholder' => '06.40.75.81.29'],
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez indiquer votre numéro de téléphone.']),
                    new Regex([
                        'pattern' => '/^(?:\+33|0)[1-9](?:\d{2}){4}$/',
                        'message' => 'Veuillez entrer un numéro de téléphone valide (ex: 06XXXXXXXX).',
                    ]),
                ],
            ])

            // === Email ===
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => ['placeholder' => 'Votre@email.fr'],
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez indiquer votre adresse email.']),
                    new Email(['message' => 'Veuillez entrer une adresse email valide.']),
                ],
            ])

            // === Mot de passe ===
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'first_options' => [
                    'label' => 'Mot de passe',
                    'attr' => ['placeholder' => 'Votre mot de passe'],
                    'help' => '8 caractères minimum, dont une majuscule, un chiffre et un caractère spécial.',
                ],
                'second_options' => [
                    'label' => 'Confirmer le mot de passe',
                    'attr' => ['placeholder' => 'Répétez le mot de passe'],
                ],
                'invalid_message' => 'Les mots de passe doivent correspondre.',
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez saisir un mot de passe.']),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères.',
                        'max' => 4096,
                    ]),
                    new Regex([
                        'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&.]).+$/',
                        'message' => 'Le mot de passe doit contenir au moins une majuscule, une minuscule, un chiffre et un caractère spécial.',
                    ]),
                ],
            ])

            // === Conditions générales ===
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label' => 'J’accepte les conditions d\'utilisation et la politique de confidentialité',
                'constraints' => [
                    new IsTrue(['message' => 'Vous devez accepter nos conditions pour continuer.']),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id'   => 'registration_item',
        ]);
    }
}


