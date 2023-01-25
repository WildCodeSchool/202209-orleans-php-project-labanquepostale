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

#[Route('/admin/question')]
class AdminQuestionController extends AbstractController
{
    #[Route('/', name: 'app_admin_question_index', methods: ['GET'])]
    public function index(QuestionRepository $questionRepository): Response
    {
        return $this->render('admin_question/index.html.twig', [
            'questions' => $questionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_question_new', methods: ['GET', 'POST'])]
    public function new(Request $request, QuestionRepository $questionRepository): Response
    {
        $question = new Question();
        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $questionRepository->save($question, true);

            return $this->redirectToRoute('app_admin_question_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_question/new.html.twig', [
            'question' => $question,
            'form' => $form,
        ]);
    }

    #[Route('/{tutorial}/leçons/{lesson}/quiz', name: 'app_admin_tutorial_lesson_quiz', methods: ['GET'])]
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

    #[Route('/{id}/edit', name: 'app_admin_question_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Question $question, QuestionRepository $questionRepository): Response
    {
        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $questionRepository->save($question, true);

            return $this->redirectToRoute('app_admin_question_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_question/edit.html.twig', [
            'question' => $question,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_question_delete', methods: ['POST'])]
    public function delete(Request $request, Question $question, QuestionRepository $questionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $question->getId(), $request->request->get('_token'))) {
            $questionRepository->remove($question, true);
        }

        return $this->redirectToRoute('app_admin_question_index', [], Response::HTTP_SEE_OTHER);
    }
}
