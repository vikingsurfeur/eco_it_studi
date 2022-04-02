<?php

namespace App\Controller;

use App\Entity\Course;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        // Find the last 6 courses
        $courses = $this->entityManager
            ->getRepository(Course::class)
            ->findBy([], ['id' => 'DESC'], 6);

        return $this->render('home/index.html.twig', [
            'courses' => $courses,
        ]);
    }
}
