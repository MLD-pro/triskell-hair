<?php

namespace App\Controller;

use App\Entity\Appointement;
use App\Form\AppointementType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class AppointementController extends AbstractController
{
    #[Route('/appointement', name: 'app_appointement')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $appointement = new Appointement();

        // Pré-remplissage si l'utilisateur est connecté
        if ($user = $this->getUser()) {
            $appointement
                ->setLastname($user->getLastName())
                ->setFirstname($user->getFirstName())
                ->setEmail($user->getEmail())
                ->setPhone($user->getPhone())
                ->setAddress($user->getAddress())
                ->setZipcode($user->getZipcode())
                ->setCity($user->getCity())
                ->setCivility($user->getCivility());
        }

        $form = $this->createForm(AppointementType::class, $appointement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Empêche tout double envoi si ce n’est pas une requête AJAX
            if ($request->isMethod('POST') && !$request->isXmlHttpRequest()) {
                return $this->redirectToRoute('app_appointement');
            }

            // Sauvegarde BDD
            $em->persist($appointement);
            $em->flush();

            // Envoi des mails uniquement si c’est AJAX
            if ($request->isXmlHttpRequest()) {
                try {
                    // --- Configuration commune ---
                    $mailConfig = function (PHPMailer $mail) {
                        $mail->isSMTP();
                        $mail->Host = 'smtp.gmail.com';
                        $mail->SMTPAuth = true;
                        $mail->Username = $_ENV['MAIL_USER'];
                        $mail->Password = $_ENV['MAIL_PASS'];
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                        $mail->Port = 587;
                        $mail->SMTPOptions = [
                            'ssl' => [
                                'verify_peer' => false,
                                'verify_peer_name' => false,
                                'allow_self_signed' => true,
                            ],
                        ];
                    };

                    // === Mail au client ===
                    $mail = new PHPMailer(true);
                    $mailConfig($mail);
                    $mail->setFrom($_ENV['MAIL_USER'], 'Triskell Hair');
                    $mail->addAddress(
                        $appointement->getEmail(),
                        $appointement->getFirstname() . ' ' . $appointement->getLastname()
                    );
                    $mail->isHTML(true);
                    $mail->Subject = 'Votre demande de rendez-vous chez Triskell Hair';
                    $mail->Body = $this->renderView('emails/appointment_client.html.twig', [
                        'appointement' => $appointement,
                    ]);
                    $mail->send();

                    // === Mail à l’admin ===
                    $adminMail = new PHPMailer(true);
                    $mailConfig($adminMail);
                    $adminMail->setFrom($_ENV['MAIL_USER'], 'Triskell Hair - Notification');
                    $adminMail->addAddress($_ENV['MAIL_USER'], 'Claire (Admin Triskell Hair)');
                    $adminMail->isHTML(true);
                    $adminMail->Subject = 'Nouvelle demande de rendez-vous client';
                    $adminMail->Body = $this->renderView('emails/appointment_admin.html.twig', [
                        'appointement' => $appointement,
                    ]);
                    $adminMail->send();

                } catch (Exception $e) {
                    error_log('Erreur PHPMailer : ' . $e->getMessage());
                }

                return $this->json([
                    'success' => true,
                    'message' => 'Votre demande de rendez-vous a bien été envoyée. Vous serez contacté rapidement.'
                ]);
            }

            // Cas non AJAX (fallback)
            $this->addFlash('success', 'Votre demande de rendez-vous a bien été envoyée. Vous serez contacté rapidement.');
            return $this->redirectToRoute('app_appointement');
        }

        return $this->render('appointement/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}







