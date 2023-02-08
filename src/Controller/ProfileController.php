<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfileType;
use App\Repository\UserRepository;
use App\Repository\LessonRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/profil', name: 'app_profile_')]
class ProfileController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(
        LessonRepository $lessonRepository,
    ): Response {

        $lessons = $lessonRepository->findAll();

        return $this->render('profile/profile.html.twig', [
            'lessons' => $lessons,
        ]);
    }

    #[Route('/editer', name: 'edit', methods: ['GET', 'POST'])]
    public function editUser(
        Request $request,
        UserRepository $userRepository
    ): Response {
        /** @var User */
        $user = $this->getUser();
        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($user, true);
            $this->addFlash('success', 'La modification a été faite avec succès.');

            return $this->redirectToRoute('app_profile', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('profile/profile_form.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
}
