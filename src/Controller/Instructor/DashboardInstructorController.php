<?php

namespace App\Controller\Instructor;

use App\Entity\Course;
use App\Entity\Image;
use App\Entity\Section;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_INSTRUCTOR')]
class DashboardInstructorController extends AbstractDashboardController
{
    #[Route('/instructor', name: 'app_instructor')]
    public function index(): Response
    {
        return $this->render('instructor/index.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Eco It - Mes Cours');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Accueil', 'fa fa-home');
        yield MenuItem::linkToCrud('Mes Images', 'fas fa-image', Image::class);
        yield MenuItem::linkToCrud('Mes Cours', 'fas fa-book', Course::class);
        yield MenuItem::linkToCrud('Mes Sections', 'fas fa-list', Section::class); 
    }
}
