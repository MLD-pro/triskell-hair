<?php

namespace App\Controller;

use App\Entity\Appointement;
use App\Form\AppointementType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppointementController extends AbstractController
{
    #[Route('/appointement', name: 'app_appointement')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $appointement = new Appointement();

        // 🔹 Si l'utilisateur est connecté, préremplir les infos connues
        $user = $this->getUser();
        if ($user) {
            $appointement->setLastname($user->getLastName());
            $appointement->setFirstname($user->getFirstName());
            $appointement->setEmail($user->getEmail());
            $appointement->setPhone($user->getPhone());
            $appointement->setAddress($user->getAddress());
            $appointement->setZipcode($user->getZipcode());
            $appointement->setCity($user->getCity());
            $appointement->setCivility($user->getCivility());
        }

        $form = $this->createForm(AppointementType::class, $appointement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Sauvegarde en base
            $em->persist($appointement);
            $em->flush();

            // Message de confirmation
            $this->addFlash('success', 'Votre demande de rendez-vous a bien été envoyée. Vous serez contacté rapidement.');

            // Redirection vers la même page
            return $this->redirectToRoute('app_appointement');
        }

        return $this->render('appointement/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}


