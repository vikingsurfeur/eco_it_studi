<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuizSectionController extends BaseController
{
    #[Route('/quiz/section/{id}', name: 'app_quiz_section')]
    public function index(): Response
    {
        return $this->render('quiz_section/index.html.twig', [
            'controller_name' => 'QuizSectionController',
        ]);
    }
}
