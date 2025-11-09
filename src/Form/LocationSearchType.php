<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;

class LocationSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('search', SearchType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Recherchez par ville ou code postal...',
                ],
                'constraints' => [
                    // Évite le champ vide
                    new NotBlank([
                        'message' => 'Veuillez entrer un nom de ville ou un code postal.',
                    ]),
                    // Longueur pour une recherche
                    new Length([
                        'min' => 2,
                        'max' => 50,
                        'minMessage' => 'Votre recherche doit contenir au moins {{ limit }} caractères.',
                        'maxMessage' => 'Votre recherche est trop longue (max {{ limit }} caractères).',
                    ]),
                    // Empêche les caractères indésirables
                    new Regex([
                        'pattern' => '/^[A-Za-zÀ-ÿ0-9\s\'-]+$/u',
                        'message' => 'Seuls les lettres, chiffres, espaces et tirets sont autorisés.',
                    ]),
                ],
            ]);
    }
}

