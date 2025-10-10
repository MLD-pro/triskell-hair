<?php

namespace App\Controller\Admin;

use App\Entity\Appointement;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class AppointementCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Appointement::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [

            // Infos client
            TextField::new('civility', 'Civilité'),
            TextField::new('lastname', 'Nom'),
            TextField::new('firstname', 'Prénom'),
            TextField::new('email', 'Email'),
            TextField::new('phone', 'Téléphone'),

            // Prestations choisies avec catégorie
            AssociationField::new('services', 'Prestations')
                ->formatValue(function ($value, $entity) {
                    // On récupère les services
                    $items = is_iterable($value) ? $value : $entity->getServices();

                    $labels = [];
                    foreach ($items as $s) {
                        // Ici, category est déjà une chaîne de caractères
                        $category = $s->getCategory();
                        $categoryName = $category !== null && $category !== '' ? $category : 'Sans catégorie';

                        $labels[] = sprintf('%s (%s)', $s->getName(), $categoryName);
                    }

                    return implode(', ', $labels);
                }),

            // 1er choix
            DateTimeField::new('date1', 'Date 1'),
            ArrayField::new('moment1', 'Créneau 1'),

            // 2e choix
            DateTimeField::new('date2', 'Date 2'),
            ArrayField::new('moment2', 'Créneau 2'),

            // 3e choix
            DateTimeField::new('date3', 'Date 3'),
            ArrayField::new('moment3', 'Créneau 3'),

            // Adresse
            TextField::new('address', 'Adresse'),
            TextField::new('zipcode', 'Code postal'),
            TextField::new('city', 'Ville'),

            // Message client
            TextareaField::new('message', 'Message')->hideOnIndex(),
        ];
    }
}



