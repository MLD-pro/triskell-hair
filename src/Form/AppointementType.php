<?php

namespace App\Form;

use App\Entity\Appointement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AppointementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('civility', ChoiceType::class, [
                'choices' => [
                    'Madame' => 'Madame',
                    'Monsieur' => 'Monsieur',
                ],
                'expanded' => true, // radio boutons
                'multiple' => false,
                'label' => 'Civilité',
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
            ->add('phone', TextType::class, [
                'label' => 'Téléphone',
                'attr' => ['placeholder' => 'Votre numéro de téléphone'],
            ])
            ->add('service', TextType::class, [
                'label' => 'Prestation souhaitée',
                'attr' => ['placeholder' => 'Ex: Coupe, coloration…'],
            ])
            ->add('date1', DateType::class, [
                'label' => '1ère date souhaitée',
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('moment1', ChoiceType::class, [
                'choices' => [
                    'Matin' => 'Matin',
                    'Après-midi' => 'Après-midi',
                ],
                'expanded' => true,
                'multiple' => false,
                'label' => 'Créneau 1',
                'required' => false,
            ])
            ->add('date2', DateType::class, [
                'label' => '2ème date souhaitée',
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('moment2', ChoiceType::class, [
                'choices' => [
                    'Matin' => 'Matin',
                    'Après-midi' => 'Après-midi',
                ],
                'expanded' => true,
                'multiple' => false,
                'label' => 'Créneau 2',
                'required' => false,
            ])
            ->add('date3', DateType::class, [
                'label' => '3ème date souhaitée',
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('moment3', ChoiceType::class, [
                'choices' => [
                    'Matin' => 'Matin',
                    'Après-midi' => 'Après-midi',
                ],
                'expanded' => true,
                'multiple' => false,
                'label' => 'Créneau 3',
                'required' => false,
            ])
            ->add('address', TextType::class, [
                'label' => 'Adresse',
                'attr' => ['placeholder' => 'Votre adresse complète'],
            ])
            ->add('zipcode', TextType::class, [
                'label' => 'Code postal',
                'attr' => ['placeholder' => 'Votre code postal'],
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville / Commune',
                'attr' => ['placeholder' => 'Votre ville'],
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Message (facultatif)',
                'required' => false,
                'attr' => ['placeholder' => 'Informations complémentaires'],
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

