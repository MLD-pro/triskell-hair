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
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom',
                'attr' => ['placeholder' => 'Votre nom'],
            ])
            ->add('firstName', TextType::class, [
                'label' => 'Prénom',
                'attr' => ['placeholder' => 'Votre prénom'],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => ['placeholder' => 'Votre adresse email'],
            ])
            ->add('phone', TelType::class, [
                'label' => 'Téléphone',
                'attr' => ['placeholder' => 'Votre numéro de téléphone'],
            ])
            ->add('services', EntityType::class, [
                'class' => Service::class,
                'choice_label' => 'name',
                'label' => 'Prestations souhaitées',
                'multiple' => true,   // multi-sélection
                'expanded' => false,  // menu déroulant au lieu de cases
                'group_by' => 'category',
            ])
            ->add('date1', DateType::class, [
                'label' => 'Date souhaitée (1er choix)',
                'widget' => 'single_text',
            ])
            ->add('moment1', ChoiceType::class, [
                'label' => false,
                'choices' => [
                    'Matin' => 'matin',
                    'Après-midi' => 'apresmidi',
                ],
                'expanded' => true, // radios
                'multiple' => true,
            ])
            ->add('date2', DateType::class, [
                'label' => 'Date souhaitée (2e choix)',
                'widget' => 'single_text',
                'required' => false,
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
            ])
            ->add('zipcode', TextType::class, [
                'label' => 'Code postal',
                'attr' => ['placeholder' => 'Votre code postal'],
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville',
                'attr' => ['placeholder' => 'Votre ville'],
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Message complémentaire (facultatif)',
                'required' => false,
                'attr' => ['placeholder' => 'Votre message...'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Appointement::class,
        ]);
    }
}


