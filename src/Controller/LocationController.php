<?php

namespace App\Controller;

use App\Form\LocationSearchType;
use App\Repository\LocationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LocationController extends AbstractController
{
    #[Route('/location', name: 'app_location')]
    public function index(Request $request, LocationRepository $locationRepository): Response
    {
        $form = $this->createForm(LocationSearchType::class);
        $form->handleRequest($request);

        $locations = [];

        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->get('search')->getData();
            $locations = $locationRepository->searchByCityOrZipcode($search);
        }

        return $this->render('location/index.html.twig', [
            'form' => $form->createView(),
            'locations' => $locations,
            'isSubmitted' => $form->isSubmitted(),
        ]);
    }
}
