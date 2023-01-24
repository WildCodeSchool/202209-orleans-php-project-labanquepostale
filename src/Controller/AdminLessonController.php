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

#[Route('/admin/lesson')]
class AdminLessonController extends AbstractController
{
    #[Route('/{id}', name: 'app_admin_lesson_delete', methods: ['POST'])]
    public function delete(Request $request, Lesson $lesson, LessonRepository $lessonRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $lesson->getId(), $request->request->get('_token'))) {
            $lessonRepository->remove($lesson, true);
            $this->addFlash('danger', 'La nouvelle leçon a été supprimée avec succès.');
        }

        return $this->redirectToRoute('app_admin_tutorial_lesson_show', ['id' => $lesson->getTutorial()->getId()]);
    }
}
