<?php

namespace App\Controller\User;

use App\Entity\UserQuizResult;
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

            MenuItem::section('Mes informations'),
            MenuItem::linkToCrud('Mon Profil', 'fas fa-user', User::class)
                ->setController(LearnerCrudController::class)
            ,

            MenuItem::section('Mes quizs'),
            MenuItem::linkToCrud('Mes quizs', 'fas fa-book', UserQuizResult::class)
                ->setController(UserQuizResultCrudController::class),

            MenuItem::section('Navigation'),
            MenuItem::linkToRoute('Retour au site', 'fas fa-sign-out-alt', 'app_home'),
        ];
    }
}
