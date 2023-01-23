<?php

namespace App\Controller;

use App\Entity\Lesson;
use App\Form\LessonType;
use App\Repository\LessonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/lesson')]
class AdminLessonController extends AbstractController
{
    #[Route('/', name: 'app_admin_lesson_index', methods: ['GET'])]
    public function index(LessonRepository $lessonRepository): Response
    {
        return $this->render('admin_lesson/index.html.twig', [
            'lessons' => $lessonRepository->findAll(),
        ]);
    }

    #[Route('/ajouter', name: 'app_admin_lesson_new', methods: ['GET', 'POST'])]
    public function new(Request $request, LessonRepository $lessonRepository): Response
    {
        $lesson = new Lesson();
        $form = $this->createForm(LessonType::class, $lesson);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lessonRepository->save($lesson, true);
            $this->addFlash('success', 'La nouvelle leçon a été crééé avec succès.');

            return $this->redirectToRoute('app_admin_lesson_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_lesson/new.html.twig', [
            'lesson' => $lesson,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/editer', name: 'app_admin_lesson_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Lesson $lesson, LessonRepository $lessonRepository): Response
    {
        $form = $this->createForm(LessonType::class, $lesson);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lessonRepository->save($lesson, true);
            $this->addFlash('success', 'La leçon a été éditée avec succès.');

            return $this->redirectToRoute('app_admin_lesson_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_lesson/edit.html.twig', [
            'lesson' => $lesson,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_lesson_delete', methods: ['POST'])]
    public function delete(Request $request, Lesson $lesson, LessonRepository $lessonRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $lesson->getId(), $request->request->get('_token'))) {
            $lessonRepository->remove($lesson, true);
        }

        return $this->redirectToRoute('app_admin_lesson_index', [], Response::HTTP_SEE_OTHER);
    }
}
