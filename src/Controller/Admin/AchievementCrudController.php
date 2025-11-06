<?php

namespace App\Controller\Admin;

use App\Entity\Achievement;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AchievementCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Achievement::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),

            // === Image "Avant" ===
            ImageField::new('imageBefore', 'Image Avant')
                ->setBasePath('uploads/achievements/')
                ->setUploadDir('public/uploads/achievements/')
                ->setUploadedFileNamePattern('[timestamp]-avant-[slug].[extension]')
                ->setRequired(false),

            TextField::new('altBefore', 'Texte alternatif (Avant)')
                ->setHelp('Description courte de la photo avant la coiffure')
                ->hideOnIndex(),

            // === Image "Après" ===
            ImageField::new('imageAfter', 'Image Après')
                ->setBasePath('uploads/achievements/')
                ->setUploadDir('public/uploads/achievements/')
                ->setUploadedFileNamePattern('[timestamp]-apres-[slug].[extension]')
                ->setRequired(false),

            TextField::new('altAfter', 'Texte alternatif (Après)')
                ->setHelp('Description courte de la photo après la coiffure')
                ->hideOnIndex(),
        ];
    }
}
