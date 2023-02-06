<?php

namespace App\Controller;

use App\Entity\Tutorial;
use App\Repository\TutorialRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/tutoriel', name: 'tutorial_')]
#[IsGranted('ROLE_USER')]
class TutorialController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(TutorialRepository $tutorialRepository): Response
    {
        $tutorials = $tutorialRepository->findAll();

        return $this->render('tutorial/index.html.twig', [
            'tutorials' => $tutorials,
        ]);
    }

    #[Route('/{id}', name: 'show')]
    public function show(Tutorial $tutorial): Response
    {
        $lessons = $tutorial->getLessons();

        return $this->render('lesson/index.html.twig', [
            'lessons' => $lessons,
            'tutorial' => $tutorial,
        ]);
    }
}
