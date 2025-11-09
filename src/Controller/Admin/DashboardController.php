<?php

namespace App\Controller\Admin;

use App\Entity\Achievement;
use App\Entity\Appointement;
use App\Entity\Location;
use App\Entity\Service;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')] 
class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $routeBuilder = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($routeBuilder->setController(UserCrudController::class)->generateUrl());
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::linkToCrud('Utilisateurs', 'fa fa-user', User::class);
        yield MenuItem::linkToCrud('Rendez-vous', 'fa fa-calendar', Appointement::class);
        yield MenuItem::linkToCrud('Prestations', 'fa fa-scissors', Service::class);
        yield MenuItem::linkToCrud('Zones de déplacement', 'fa fa-map-marker-alt', Location::class);
        yield MenuItem::linkToCrud('Réalisations', 'fa fa-image', Achievement::class);
    }
}

