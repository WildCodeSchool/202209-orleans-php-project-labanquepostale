<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Lesson;
use App\Entity\Tutorial;
use App\Form\QuizLessonType;
use App\Service\CheckGoodAnswer;
use App\Repository\LessonRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/tutoriel', name: 'tutorial_lesson_')]
class LessonController extends AbstractController
{
    private CheckGoodAnswer $checkGoodAnswer;

    public function __construct(CheckGoodAnswer $checkGoodAnswer)
    {
        $this->checkGoodAnswer = $checkGoodAnswer;
    }

    #[Route('/{tutorial}/lecon/{lesson}', requirements: ['id' => '\d+'], name: 'show')]
    public function show(
        Lesson $lesson,
        Request $request,
        LessonRepository $lessonRepository,
        Tutorial $tutorial,
    ): Response {
        $quizzDone = $lesson->getUsers()->contains($this->getUser());

        if (!$quizzDone) {
            $form = $this->createForm(QuizLessonType::class, $lesson);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                /** @var User */
                $user = $this->getUser();
                $answerIds = $request->request->all('quiz_lesson')['questions'];
                $isGoodAnswer = $this->checkGoodAnswer->checkQuizz($answerIds);
                if ($isGoodAnswer) {
                    $lesson->addUser($user);
                    $lessonRepository->save($lesson, true);
                    return $this->redirectToRoute('tutorial_lesson_show', ['id' => $lesson->getId()]);
                } else {
                    $this->addFlash('danger', 'Presque ! Réessaie !');
                }
            }
        }
        return $this->renderForm('lesson/show.html.twig', [
            'form' => $form ?? null,
            'quizzDone' => $quizzDone,
            'lesson' => $lesson,
            'tutorial' => $tutorial,
        ]);
    }
}
