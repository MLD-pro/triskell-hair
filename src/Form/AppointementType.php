<?php

namespace App\Form;

use App\Entity\Appointement;
use App\Entity\Service;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;

class AppointementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('civility', ChoiceType::class, [
                'label' => false,
                'choices' => [
                    'Monsieur' => 'M.',
                    'Madame' => 'Mme',
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez sélectionner votre civilité.']),
                ],
            ])

            ->add('lastName', TextType::class, [
                'label' => 'Nom',
                'attr' => ['placeholder' => 'Votre nom'],
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez renseigner votre nom.']),
                    new Length(['min' => 2, 'max' => 100]),
                    new Regex([
                        'pattern' => '/^[A-Za-zÀ-ÿ\s\'-]+$/u',
                        'message' => 'Le nom ne peut contenir que des lettres, des espaces ou des tirets.',
                    ]),
                ],
            ])

            ->add('firstName', TextType::class, [
                'label' => 'Prénom',
                'attr' => ['placeholder' => 'Votre prénom'],
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez renseigner votre prénom.']),
                    new Length(['min' => 2, 'max' => 100]),
                ],
            ])

            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => ['placeholder' => 'Votre adresse email'],
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez renseigner votre adresse email.']),
                    new Email(['message' => 'Veuillez entrer une adresse email valide.']),
                ],
            ])

            ->add('phone', TelType::class, [
                'label' => 'Téléphone',
                'attr' => ['placeholder' => 'Votre numéro de téléphone'],
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez indiquer votre numéro de téléphone.']),
                    new Regex([
                        'pattern' => '/^(?:\+33|0)[1-9](?:\d{2}){4}$/',
                        'message' => 'Veuillez entrer un numéro de téléphone valide (ex: 06XXXXXXXX).',
                    ]),
                ],
            ])

            ->add('services', EntityType::class, [
                'class' => Service::class,
                'choice_label' => 'name',
                'label' => 'Prestations souhaitées',
                'multiple' => true,
                'expanded' => false,
                'group_by' => 'category',
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez sélectionner au moins une prestation.']),
                ],
            ])

            ->add('date1', DateType::class, [
                'label' => 'Date souhaitée (1er choix)',
                'widget' => 'single_text',
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez indiquer une première date de rendez-vous.']),
                    new GreaterThanOrEqual([
                        'value' => (new \DateTime())->format('Y-m-d'),
                        'message' => 'La date du rendez-vous ne peut pas être dans le passé.',
                    ]),
                ],
            ])

            ->add('moment1', ChoiceType::class, [
                'label' => false,
                'choices' => [
                    'Matin' => 'matin',
                    'Après-midi' => 'apresmidi',
                ],
                'expanded' => true,
                'multiple' => true,
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez choisir un moment de la journée.']),
                ],
            ])

            ->add('date2', DateType::class, [
                'label' => 'Date souhaitée (2e choix)',
                'widget' => 'single_text',
                'required' => false,
                'constraints' => [
                    new GreaterThanOrEqual([
                        'value' => (new \DateTime())->format('Y-m-d'),
                        'message' => 'La date du rendez-vous ne peut pas être dans le passé.',
                    ]),
                ],
            ])

            ->add('moment2', ChoiceType::class, [
                'label' => false,
                'choices' => [
                    'Matin' => 'matin',
                    'Après-midi' => 'apresmidi',
                ],
                'expanded' => true,
                'multiple' => true,
                'required' => false,
            ])

            ->add('date3', DateType::class, [
                'label' => 'Date souhaitée (3e choix)',
                'widget' => 'single_text',
                'required' => false,
                'constraints' => [
                    new GreaterThanOrEqual([
                        'value' => (new \DateTime())->format('Y-m-d'),
                        'message' => 'La date du rendez-vous ne peut pas être dans le passé.',
                    ]),
                ],
            ])

            ->add('moment3', ChoiceType::class, [
                'label' => false,
                'choices' => [
                    'Matin' => 'matin',
                    'Après-midi' => 'apresmidi',
                ],
                'expanded' => true,
                'multiple' => true,
                'required' => false,
            ])

            ->add('address', TextType::class, [
                'label' => 'Adresse',
                'attr' => ['placeholder' => 'Votre adresse'],
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez indiquer votre adresse.']),
                ],
            ])

            ->add('zipcode', TextType::class, [
                'label' => 'Code postal',
                'attr' => ['placeholder' => 'Votre code postal'],
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez indiquer votre code postal.']),
                    new Regex([
                        'pattern' => '/^[0-9]{5}$/',
                        'message' => 'Le code postal doit contenir 5 chiffres.',
                    ]),
                ],
            ])

            ->add('city', TextType::class, [
                'label' => 'Ville',
                'attr' => ['placeholder' => 'Votre ville'],
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez indiquer votre ville.']),
                ],
            ])

            ->add('message', TextareaType::class, [
                'label' => 'Message complémentaire (facultatif)',
                'required' => false,
                'attr' => ['placeholder' => 'Votre message...'],
                'constraints' => [
                    new Length(['max' => 1000]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Appointement::class,
        ]);
    }
}



