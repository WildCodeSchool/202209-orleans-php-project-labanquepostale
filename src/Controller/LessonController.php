<?php

namespace App\Controller;

use App\Entity\Lesson;
use App\Entity\Tutorial;
use App\Repository\LessonRepository;
use App\Repository\QuestionRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/lesson', name: 'lesson_')]
class LessonController extends AbstractController
{
    #[Route('/show/{id}', requirements: ['id' => '\d+'], name: 'show')]
    public function show(Tutorial $tutorial, Lesson $lesson, QuestionRepository $questionRepository): Response
    {
        $questions = $questionRepository->findBy(['lesson' => $lesson]);

        return $this->render('lesson/show.html.twig', [
            'tutorial' => $tutorial,
            'lesson' => $lesson,
            'questions' => $questions,
        ]);
    }

    #[Route('/{id}', name: 'index')]
    public function index(Tutorial $tutorial): Response
    {
        $lessons = $tutorial->getLessons();

        return $this->render('lesson/index.html.twig', [
            'tutorial' => $tutorial,
            'lessons' => $lessons,
        ]);
    }
}
