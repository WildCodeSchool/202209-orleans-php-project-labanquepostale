<?php

namespace App\Controller;

use App\Entity\Lesson;
use App\Repository\LessonRepository;
use App\Repository\QuestionRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/lesson', name: 'lesson_')]
class LessonController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(LessonRepository $lessonRepository): Response
    {
        $lessons = $lessonRepository->findAll();

        return $this->render('lesson/index.html.twig', [
            'lessons' => $lessons,
        ]);
    }
    #[Route('/show/{id}', requirements: ['id' => '\d+'], name: 'show')]
    public function show(Lesson $lesson, QuestionRepository $questionRepository): Response
    {
        $questions = $questionRepository->findAll();

        return $this->render('lesson/show.html.twig', [
            'lesson' => $lesson,
            'questions' => $questions
        ]);
    }
}
