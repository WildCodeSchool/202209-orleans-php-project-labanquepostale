<?php

namespace App\Controller;

use App\Entity\Lesson;
use App\Entity\Question;
use App\Form\LessonType;
use App\Form\ResponseType;
use App\Form\QuizzQuestionType;
use App\Repository\LessonRepository;
use App\Repository\QuestionRepository;
use App\Repository\ResponseRepository;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/show/{id}', name: 'show')]
    public function test(
        Lesson $lesson,
        Request $request,
        ResponseRepository $responseRepository,
    ): Response {
        $form = $this->createForm(LessonType::class, $lesson);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($request->request->all()['lesson']['questions'] as $response) {
                $selectedResponse = $responseRepository->find($response['response']);
            }
            $this->addFlash('success', 'BRAVO ! Vous avez validé le quiz !');
        }

        return $this->renderForm('lesson/show.html.twig', [
            'form' => $form,
            'lesson' => $lesson,
        ]);
    }
}
