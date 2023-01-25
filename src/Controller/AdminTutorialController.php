<?php

namespace App\Controller;

use App\Entity\Lesson;
use App\Entity\Question;
use App\Entity\Tutorial;
use App\Form\QuestionType;
use App\Form\TutorialType;
use App\Repository\QuestionRepository;
use App\Repository\TutorialRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/tutoriel')]
class AdminTutorialController extends AbstractController
{
    #[Route('/', name: 'app_admin_tutorial_index', methods: ['GET'])]
    public function index(TutorialRepository $tutorialRepository): Response
    {
        return $this->render('admin_tutorial/index.html.twig', [
            'tutorials' => $tutorialRepository->findAll(),
        ]);
    }

    #[Route('/ajouter', name: 'app_admin_tutorial_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TutorialRepository $tutorialRepository): Response
    {
        $tutorial = new Tutorial();
        $form = $this->createForm(TutorialType::class, $tutorial);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tutorialRepository->save($tutorial, true);
            $this->addFlash('success', 'Le nouveau tutoriel a été créé avec succès.');

            return $this->redirectToRoute('app_admin_tutorial_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_tutorial/new.html.twig', [
            'tutorial' => $tutorial,
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

    #[Route('/{id}/editer', name: 'app_admin_tutorial_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Tutorial $tutorial, TutorialRepository $tutorialRepository): Response
    {
        $form = $this->createForm(TutorialType::class, $tutorial);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tutorialRepository->save($tutorial, true);
            $this->addFlash('success', 'Le tutoriel a été édité avec succès.');

            return $this->redirectToRoute('app_admin_tutorial_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_tutorial/edit.html.twig', [
            'tutorial' => $tutorial,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_tutorial_delete', methods: ['POST'])]
    public function delete(Request $request, Tutorial $tutorial, TutorialRepository $tutorialRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $tutorial->getId(), $request->request->get('_token'))) {
            $tutorialRepository->remove($tutorial, true);
        }

        return $this->redirectToRoute('app_admin_tutorial_index', [], Response::HTTP_SEE_OTHER);
    }
}
