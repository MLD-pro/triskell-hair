<?php

namespace App\Controller;

use App\Repository\AchievementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AchievementsController extends AbstractController
{
    #[Route('/achievements', name: 'app_achievements')]
    public function index(AchievementRepository $achievementRepository): Response
    {
        $achievements = $achievementRepository->findAll();

        return $this->render('achievements/index.html.twig', [
            'achievements' => $achievements,
        ]);
    }
}

