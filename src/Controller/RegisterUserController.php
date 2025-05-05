<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RegisterUserController extends AbstractController
{
    #[Route('/inscription', name: 'app_register_user')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationUserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setRoles(['ROLE_USER']);
            $entityManager->persist($user);
            $entityManager->flush();

            // Redirection ou message de succès
            //$this->addFlash('success', 'Inscription réussie !');
            return $this->redirectToRoute('app_login'); // Redirection vers la page de login après inscription
        }

        return $this->render('register_user/index.html.twig', [
           'userForm' => $form->createView(),
        ]);
    }
}
