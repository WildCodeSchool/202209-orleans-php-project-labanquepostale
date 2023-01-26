<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Lesson;
use App\Entity\Tutorial;
use App\Entity\Explanation;
use App\Form\QuizLessonType;
use App\Repository\LessonRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/lesson', name: 'lesson_')]
class LessonController extends AbstractController
{
    #[Route('/{id}', name: 'index')]
    public function index(Tutorial $tutorial): Response
    {
        $lessons = $tutorial->getLessons();

        return $this->render('lesson/index.html.twig', [
            'lessons' => $lessons,
            'tutorial' => $tutorial,
        ]);
    }

    #[Route('/show/{id}', requirements: ['id' => '\d+'], name: 'show')]
    public function show(
        Lesson $lesson,
        Request $request,
        LessonRepository $lessonRepository,
        Explanation $explanation
    ): Response {
        $tutorial = $lesson->getTutorial();
        $quizzDone = $lesson->getUsers()->contains($this->getUser());
        if (!$quizzDone) {
            $form = $this->createForm(QuizLessonType::class, $lesson);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                /** @var User */
                $user = $this->getUser();
                $lesson->addUser($user);

                $lessonRepository->save($lesson, true);
                return $this->redirectToRoute('lesson_show', ['id' => $lesson->getId()]);
            }
        }
        return $this->renderForm('lesson/show.html.twig', [
            'form' => $form ?? null,
            'quizzDone' => $quizzDone,
            'lesson' => $lesson,
            'tutorial' => $tutorial,
            'explanation' => $explanation
        ]);
    }
}
