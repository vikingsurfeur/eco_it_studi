<?php

namespace App\Controller\User;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_USER')]
class DashboardUserController extends AbstractDashboardController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('ECO IT - ESPACE APPRENANT');
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Accueil', 'fa fa-home'),

            MenuItem::section('Mes Cours'),
            // MenuItem::linkToCrud('Mes Cours', 'fas fa-book', Course::class),
                // ->setController(LearnerCourseCrudController::class)
            // MenuItem::linkToCrud('Mes Sections', 'fas fa-list', Section::class),
                // ->setController(LearnerSectionCrudController::class)
            // MenuItem::linkToCrud('Mes Lessons', 'fas fa-pen', Lesson::class),
                // ->setController(LearnerLessonCrudController::class)

            MenuItem::section('Mes informations'),
            MenuItem::linkToCrud('Mon Profil', 'fas fa-user', User::class)
                ->setController(LearnerCrudController::class)
            ,
        ];
    }
}
