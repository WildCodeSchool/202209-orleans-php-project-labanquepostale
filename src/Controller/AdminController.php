<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    #[Route('/admin/lesson', name: 'app_admin_lesson')]
    public function lesson(): Response
    {
        return $this->render('admin/lesson.html.twig');
    }

    #[Route('/admin/quiz', name: 'app_admin_quizz')]
    public function quiz(): Response
    {
        return $this->render('admin/quiz.html.twig');
    }
}
