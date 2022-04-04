<?php

namespace App\Controller;

use App\Repository\CourseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(CourseRepository $courseRepository): Response
    {
        // Find the last 6 courses
        $courses = $courseRepository->findBy([], ['id' => 'DESC'], 6);

        return $this->render('home/index.html.twig', [
            'courses' => $courses,
        ]);
    }
}
