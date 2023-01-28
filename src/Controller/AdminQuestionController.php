<?php

namespace App\Controller;

use App\Entity\Lesson;
use App\Entity\Question;
use App\Entity\Tutorial;
use App\Form\QuestionType;
use App\Repository\QuestionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/tutoriel', name: 'app_admin_tutorial_lesson_quiz_')]
class AdminQuestionController extends AbstractController
{
    #[Route('/{tutorial}/lecon/{lesson}/quiz', name: 'show', methods: ['GET'])]
    public function showQuiz(
        Request $request,
        Tutorial $tutorial,
        Lesson $lesson,
        Question $question,
        QuestionRepository $questionRepository
    ): Response {
        $questions = $lesson->getQuestions();

        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $questionRepository->save($question, true);

            return $this->redirectToRoute('app_admin_tutorial_lesson_quiz', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_tutorial/quiz_index.html.twig', [
            'tutorial' => $tutorial,
            'lesson' => $lesson,
            'questions' => $questions,
            'form' => $form
        ]);
    }

    #[Route('/{tutorial}/lecon/{lesson}/quiz/ajouter', name: 'new', methods: ['GET', 'POST'])]
    public function newQuiz(
        Request $request,
        Tutorial $tutorial,
        Lesson $lesson,
        QuestionRepository $questionRepository,
    ): Response {
        $question = new Question();
        $question->setLesson($lesson);
        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $questionRepository->save($question, true);
            $this->addFlash('success', 'La nouvelle leçon a été crééé avec succès.');

            return $this->redirectToRoute(
                'app_admin_tutorial_lesson_quiz_show',
                ['tutorial' => $tutorial->getId(), 'lesson' => $lesson->getId()]
            );
        }

        return $this->renderForm('admin_question/new.html.twig', [
            'tutorial' => $tutorial,
            'lesson' => $lesson,
            'question' => $question,
            'form' => $form,
        ]);
    }


    #[Route('/{tutorial}/lecons/{lesson}/quiz/editer', name: 'edit', methods: ['GET', 'POST'])]
    public function editQuiz(
        Request $request,
        Question $question,
        Tutorial $tutorial,
        Lesson $lesson,
        QuestionRepository $questionRepository
    ): Response {
        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $questionRepository->save($question, true);
            $this->addFlash('info', 'La nouvelle leçon a été éditée avec succès.');

            return $this->redirectToRoute(
                'app_admin_tutorial_lesson_quiz_show',
                ['tutorial' => $tutorial->getId(), 'lesson' => $lesson->getId()]
            );
        }

        return $this->renderForm('admin_question/edit.html.twig', [
            'tutorial' => $tutorial,
            'lesson' => $lesson,
            'question' => $question,
            'form' => $form,
        ]);
    }

    #[Route('/{tutorial}/lecon/{lesson}/quiz/{question}/supprimer', name: 'delete', methods: ['POST'])]
    public function deleteQuiz(
        Request $request,
        Question $question,
        Tutorial $tutorial,
        Lesson $lesson,
        QuestionRepository $questionRepository
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $question->getId(), $request->request->get('_token'))) {
            $questionRepository->remove($question, true);
            $this->addFlash('danger', 'La nouvelle leçon a été supprimée avec succès.');
        }

        return $this->redirectToRoute(
            'app_admin_tutorial_lesson_quiz_show',
            ['tutorial' => $tutorial->getId(), 'lesson' => $lesson->getId()]
        );
    }
}
