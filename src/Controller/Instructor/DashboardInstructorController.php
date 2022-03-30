<?php

namespace App\Controller\Instructor;

use App\Entity\Course;
use App\Entity\Lesson;
use App\Entity\Section;
use App\Entity\Tag;
use App\Entity\User;
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
            ->setTitle('ECO IT - ADMINISTRATION FORMATEUR');
    }

    public function configureMenuItems(): iterable
    {
        $isAcceptedInstructor = $this->getUser()->getIsAccepted();

        if ($isAcceptedInstructor) {
            return [
                MenuItem::linkToDashboard('Accueil', 'fa fa-home'),

                // MenuItem::section('Gestion des images'),
                // MenuItem::linkToCrud('Mes Images', 'fas fa-image', Image::class),

                MenuItem::section('Mes Cours'),
                MenuItem::linkToCrud('Mes Cours', 'fas fa-book', Course::class),
                MenuItem::linkToCrud('Mes Sections', 'fas fa-list', Section::class),
                MenuItem::linkToCrud('Mes Lessons', 'fas fa-pen', Lesson::class),
                MenuItem::linkToCrud('Mes Tags', 'fas fa-tags', Tag::class),

                MenuItem::section('Mes informations'),
                MenuItem::linkToCrud('Mon Profil', 'fas fa-user', User::class)
                    ->setController(InstructorCrudController::class)
                ,
            ];
        } else {
            return [
                MenuItem::linkToDashboard('Accueil', 'fa fa-home'),
            ];
        }
    }
}
