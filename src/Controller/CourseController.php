<?php

namespace App\Controller;

use App\Repository\CourseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

class CourseController extends AbstractController
{
    #[Route('/course', name: 'app_course')]
    public function index(
        CourseRepository $courseRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response
    {
        if (!$this->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('app_login');
        }
        
        $data = $courseRepository->findAll();

        $courses = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            6
        );

        return $this->render('course/index.html.twig', [
            'courses' => $courses,
        ]);
    }

    #[Route('/course/{slug}', name: 'app_course_show_slug')]
    public function showOne(CourseRepository $courseRepository, string $slug): Response
    {
        if (!$this->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('app_login');
        }

        $course = $courseRepository->findBy(['slug' => $slug]);

        return $this->render('course/show.one.html.twig', [
            'course' => $course,
        ]);
    }
}
