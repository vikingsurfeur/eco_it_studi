<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationInstructorFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\Security\Http\Authenticator\FormLoginAuthenticator;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationInstructorController extends AbstractController
{
    #[Route('/register-instructor', name: 'app_register_instructor')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, UserAuthenticatorInterface $userAuthenticator, FormLoginAuthenticator $formLoginAuthenticator): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationInstructorFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
            $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            // Give the instructor role to this user
            $user->setRoles(['ROLE_INSTRUCTOR']);

            // Set the instructor's accepted to false
            $user->setIsAccepted(false);

            $entityManager->persist($user);
            $entityManager->flush();

            $userAuthenticator->authenticateUser(
                $user,
                $formLoginAuthenticator,
                $request,
            );

            return $this->redirectToRoute('app_home');
        }

        return $this->render('registration/register.instructor.html.twig', [
            'registrationFormInstructor' => $form->createView(),
        ]);
    }
}
