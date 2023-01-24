<?php

namespace App\Controller;

use App\Entity\Lesson;
use App\Entity\Tutorial;
use App\Form\LessonType;
use App\Form\TutorialType;
use App\Repository\LessonRepository;
use App\Repository\TutorialRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/tutoriel', name: 'app_admin_tutorial_')]
class AdminTutorialController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(TutorialRepository $tutorialRepository): Response
    {
        return $this->render('admin_tutorial/index.html.twig', [
            'tutorials' => $tutorialRepository->findAll(),
        ]);
    }

    #[Route('/ajouter', name: 'new', methods: ['GET', 'POST'])]
    public function newTutorial(Request $request, TutorialRepository $tutorialRepository): Response
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


    #[Route('/{id}/lecons', name: 'lesson_show', methods: ['GET'])]
    public function showLessons(Tutorial $tutorial): Response
    {
        $lessons = $tutorial->getLessons();

        return $this->render('admin_tutorial/lessons_index.html.twig', [
            'tutorial' => $tutorial,
            'lessons' => $lessons,
            'tutoriel' => $tutorial
        ]);
    }

    #[Route('/{tutoriel}/lecons/ajouter', name: 'lesson_new', methods: ['GET', 'POST'])]
    public function newLesson(Request $request, LessonRepository $lessonRepository, Tutorial $tutoriel): Response
    {
        $lesson = new Lesson();
        $form = $this->createForm(LessonType::class, $lesson);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lesson->setTutorial($tutoriel);
            $lessonRepository->save($lesson, true);
            $this->addFlash('success', 'La nouvelle leçon a été crééé avec succès.');

            return $this->redirectToRoute('app_admin_tutorial_lesson_show', ['id' => $tutoriel->getId()]);
        }

        return $this->renderForm('admin_lesson/new.html.twig', [
            'lesson' => $lesson,
            'form' => $form,
            'tutorial' => $tutoriel
        ]);
    }

    #[Route('/{id}/editer', name: 'edit', methods: ['GET', 'POST'])]
    public function editTutorial(Request $request, Tutorial $tutorial, TutorialRepository $tutorialRepository): Response
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

    #[Route('/{tutorial}/lecon/{lesson}/editer', name: 'lesson_edit', methods: ['GET', 'POST'])]
    public function editLesson(Request $request, Lesson $lesson, LessonRepository $lessonRepository): Response
    {
        $form = $this->createForm(LessonType::class, $lesson);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lessonRepository->save($lesson, true);
            $this->addFlash('success', 'La leçon a été éditée avec succès.');

            return $this->redirectToRoute('app_admin_tutorial_lesson_show', ['id' => $lesson->getTutorial()->getId()]);
        }

        return $this->renderForm('admin_lesson/edit.html.twig', [
            'lesson' => $lesson,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function deleteTutorial(
        Request $request,
        Tutorial $tutorial,
        TutorialRepository $tutorialRepository
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $tutorial->getId(), $request->request->get('_token'))) {
            $tutorialRepository->remove($tutorial, true);
            $this->addFlash('danger', 'Le nouveau tutoriel a été supprimé avec succès.');
        }

        return $this->redirectToRoute('app_admin_tutorial_index', [], Response::HTTP_SEE_OTHER);
    }
}
