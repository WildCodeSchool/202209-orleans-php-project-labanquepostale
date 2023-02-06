<?php

namespace App\Controller;

use App\Entity\Tutorial;
use App\Repository\LessonRepository;
use App\Repository\TutorialRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

#[Route('/tutoriel', name: 'tutorial_')]
class TutorialController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(TutorialRepository $tutorialRepository): Response
    {
        $tutorials = $tutorialRepository->findAll();
        $user = $this->getUser();
        if (!$user) {
            throw new AccessDeniedException('Accès refusé');
        }

        return $this->render('tutorial/index.html.twig', [
            'tutorials' => $tutorials,
        ]);
    }

    #[Route('/{id}', name: 'show')]
    public function show(Tutorial $tutorial): Response
    {
        $lessons = $tutorial->getLessons();
        $user = $this->getUser();
        if (!$user) {
            throw new AccessDeniedException('Accès refusé');
        }

        return $this->render('lesson/index.html.twig', [
            'lessons' => $lessons,
            'tutorial' => $tutorial,
        ]);
    }
}
