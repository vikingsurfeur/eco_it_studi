<?php

namespace App\Controller;

use App\Entity\Course;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CourseController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/course', name: 'app_course')]
    public function index(): Response
    {
        $courses = $this->entityManager
            ->getRepository(Course::class)
            ->findAll();

        return $this->render('course/index.html.twig', [
            'courses' => $courses,
        ]);
    }

    #[Route('/course/{slug}', name: 'app_course_show_slug')]
    public function showOne(string $slug): Response
    {
        $course = $this->entityManager
            ->getRepository(Course::class)
            ->findBy(['slug' => $slug]);

        return $this->render('course/show.one.html.twig', [
            'course' => $course,
        ]);
    }
}
