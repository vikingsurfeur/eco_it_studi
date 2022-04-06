<?php

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserCourseController extends AbstractController
{
    #[Route('/user/course', name: 'app_user_course')]
    public function index(): Response
    {
        return $this->render('user/user.course.html.twig');
    }
}