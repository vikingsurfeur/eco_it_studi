<?php

namespace App\Controller;

use App\Form\QuizFormType;
use App\Repository\QuizRepository;
use App\Repository\SectionRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuizSectionController extends BaseController
{
    #[Route('/quiz/section/{id}', name: 'app_quiz_section')]
    public function index(
        int $id,
        SectionRepository $sectionRepository,
        QuizRepository $quizRepository,
    ): Response
    {
        if (!$this->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('app_login');
        }
        
        // Retrieve the section by his id
        $section = $sectionRepository->find($id);

        // Retrieve the quiz by his section id
        $quiz = $quizRepository->findOneBy(['section' => $section->getId()]);

        // Create the form with this quiz
        $form = $this->createForm(QuizFormType::class, null, [
            'quiz' => $quiz,
        ]);

        return $this->render('quiz_section/index.html.twig', [
            'quiz' => $quiz,
            'form_quiz' => $form->createView(),
        ]);
    }
}
