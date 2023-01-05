<?php

namespace App\Controller;

use App\Entity\Tutorial;
use App\Repository\LessonRepository;
use App\Repository\TutorialRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/tutorial', name: 'tutorial_')]
class TutorialController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(TutorialRepository $tutorialRepository): Response
    {
        $tutorials = $tutorialRepository->findAll();

        return $this->render('tutorial/index.html.twig', [
            'tutorials' => $tutorials,
        ]);
    }

    #[Route('/show/{id}', requirements: ['id' => '\d+'], name: 'show')]
    public function show(Tutorial $tutorial, LessonRepository $lessonRepository): Response
    {
        $lesson = $lessonRepository->findBy(['tutorial' => $tutorial]);

        return $this->render('tutorial/show.html.twig', [
            'lesson' => $lesson,
            'tutorial' => $tutorial
        ]);
    }
}
