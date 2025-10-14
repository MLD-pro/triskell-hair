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

        // Si l'utilisateur est connecté, préremplir les infos connues
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

            //  Envoi du mail automatique avec PHPMailer
            try {
                $mail = new PHPMailer(true);
                $mail->SMTPDebug = 2; // 🔍 affiche les détails de la connexion SMTP
                $mail->Debugoutput = 'error_log'; // 🔍 envoie les logs vers error_log()

                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = $_ENV['MAIL_USER'];
                $mail->Password = $_ENV['MAIL_PASS'];
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Désactive la vérification SSL (utile en local)
                $mail->SMTPOptions = [
                    'ssl' => [
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true,
                    ],
                ];

                // Expéditeur et destinataire
                $mail->setFrom($_ENV['MAIL_USER'], 'Triskell Hair');
                $mail->addAddress(
                    $appointement->getEmail(),
                    $appointement->getFirstName() . ' ' . $appointement->getLastName()
                );

                // Contenu du mail
                $mail->isHTML(true);
                $mail->Subject = 'Votre demande de rendez-vous chez Triskell Hair';
                $mail->Body = "
                    <p>Bonjour <strong>{$appointement->getFirstName()}</strong>,</p>
                    <p>J'ai bien reçu votre demande de rendez-vous.</p>
                    <p>Je vous contacte par téléphone très prochainement afin de convenir ensemble d’un horaire précis.</p>
                    <p>Merci pour votre confiance et à bientôt,<br><strong>Claire de Triskell Hair</strong></p>
                ";

                $mail->send();
            } catch (Exception $e) {
                dd('Erreur PHPMailer : ' . $mail->ErrorInfo);
            }

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






