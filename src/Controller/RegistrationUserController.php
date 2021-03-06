<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationUserFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\Security\Http\Authenticator\FormLoginAuthenticator;

class RegistrationUserController extends AbstractController
{
    #[Route('/register-learner', name: 'app_register_user')]
    public function register(
        Request $request, 
        UserPasswordHasherInterface $userPasswordHasher, 
        UserAuthenticatorInterface $userAuthenticator, 
        EntityManagerInterface $entityManager, 
        FormLoginAuthenticator $formLoginAuthenticator
        ): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationUserFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
            $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

            $userAuthenticator->authenticateUser(
                $user,
                $formLoginAuthenticator,
                $request,
            );

            // Display a message to say the user was created
            $this->addFlash('success', 'Votre compte a bien été créé.');

            return $this->redirectToRoute('app_user');
        }

        return $this->render('registration/register.user.html.twig', [
            'registrationFormUser' => $form->createView(),
        ]);
    }
}
