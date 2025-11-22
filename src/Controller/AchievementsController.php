<?php

namespace App\Controller;

use App\Repository\AchievementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AchievementsController extends AbstractController
{
    #[Route('/realisations', name: 'app_achievements')]
    public function index(AchievementRepository $achievementRepository): Response
    {
        // On trie les réalisations par position croissante (1, 2, 3, ...)
        $achievements = $achievementRepository->findBy([], ['position' => 'ASC']);

        return $this->render('achievements/index.html.twig', [
            'achievements' => $achievements,
        ]);
    }
}

