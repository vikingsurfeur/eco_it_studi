<?php

namespace App\Controller\User;

use App\Controller\BaseController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserCourseController extends BaseController
{
    #[Route('/user/course', name: 'app_user_course')]
    public function index(): Response
    {
        if (!$this->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('app_login');
        }
        
        // Get the user subscribed courses
        $userSubscribedCourses = $this->getUser()->getLearnersCourses();
        $courses = $userSubscribedCourses->getValues();

        return $this->render('user/user.course.html.twig', [
            'courses' => $courses,
        ]);
    }
}