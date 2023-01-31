<?php

namespace App\Controller;

use App\Entity\Lesson;
use App\Entity\Tutorial;
use App\Form\LessonType;
use App\Repository\LessonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/tutoriel', name: 'app_admin_tutorial_lesson_')]
class AdminLessonController extends AbstractController
{
    #[Route('/{id}/lecon', name: 'show', methods: ['GET'])]
    public function showLessons(Tutorial $tutorial): Response
    {
        $lessons = $tutorial->getLessons();

        return $this->render('admin_tutorial/lessons_index.html.twig', [
            'tutorial' => $tutorial,
            'lessons' => $lessons,
            'tutoriel' => $tutorial
        ]);
    }

    #[Route('/{tutorial}/lecon/ajouter', name: 'new', methods: ['GET', 'POST'])]
    public function newLesson(Request $request, LessonRepository $lessonRepository, Tutorial $tutorial): Response
    {
        $lesson = new Lesson();
        $form = $this->createForm(LessonType::class, $lesson);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lesson->setTutorial($tutorial);
            $lessonRepository->save($lesson, true);
            $this->addFlash('success', 'La nouvelle leçon a été crééé avec succès.');

            return $this->redirectToRoute('app_admin_tutorial_lesson_show', ['id' => $tutorial->getId()]);
        }

        return $this->renderForm('admin_lesson/new.html.twig', [
            'lesson' => $lesson,
            'form' => $form,
            'tutorial' => $tutorial
        ]);
    }

    #[Route('/{tutorial}/lecon/{lesson}/editer', name: 'edit', methods: ['GET', 'POST'])]
    public function editLesson(Request $request, Lesson $lesson, LessonRepository $lessonRepository): Response
    {
        $form = $this->createForm(LessonType::class, $lesson);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lessonRepository->save($lesson, true);
            $this->addFlash('info', 'La leçon a été éditée avec succès.');

            return $this->redirectToRoute('app_admin_tutorial_lesson_show', ['id' => $lesson->getTutorial()->getId()]);
        }

        return $this->renderForm('admin_lesson/edit.html.twig', [
            'lesson' => $lesson,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/supprimer', name: 'delete', methods: ['POST'])]
    public function deleteLesson(Request $request, Lesson $lesson, LessonRepository $lessonRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $lesson->getId(), $request->request->get('_token'))) {
            $lessonRepository->remove($lesson, true);
            $this->addFlash('danger', 'La leçon a été supprimée avec succès.');
        }

        return $this->redirectToRoute('app_admin_tutorial_lesson_show', ['id' => $lesson->getTutorial()->getId()]);
    }
}
