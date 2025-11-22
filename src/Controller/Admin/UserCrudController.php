<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),

            EmailField::new('email', 'Email'),

            TextField::new('lastName', 'Nom'),
            TextField::new('firstName', 'Prénom'),
            TextField::new('city', 'Ville')->hideOnIndex(),
            TextField::new('zipcode', 'Code postal')->hideOnIndex(),
            TextField::new('address', 'Adresse')->hideOnIndex(),
            TelephoneField::new('phone', 'Téléphone')->hideOnIndex(),

            // Choix des rôles (modifiable depuis l’admin)
            ChoiceField::new('roles', 'Rôles')
                ->allowMultipleChoices()
                ->setChoices([
                    'Utilisateur' => 'ROLE_USER',
                    'Administrateur' => 'ROLE_ADMIN',
                ])
                ->renderExpanded(false) // select normal
                ->renderAsBadges()      // joli affichage dans la liste
        ];
    }
}




