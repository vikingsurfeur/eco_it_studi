<?php

namespace App\Controller;

use App\Form\UserSubscriberCourseType;
use App\Repository\CourseRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

class CourseController extends BaseController
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
        
        // Retrive all courses
        $data = $courseRepository->findAll();

        // Define the pagination
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
    public function showOne(
        CourseRepository $courseRepository,
        Request $request, 
        string $slug
    ): Response
    {
        if (!$this->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('app_login');
        }

        // Render the user subscription form
        $userSubscriberCourseForm = $this->createForm(UserSubscriberCourseType::class);
        $userSubscriberCourseForm->handleRequest($request);

        // Form Action
        if ($userSubscriberCourseForm->isSubmitted() && $userSubscriberCourseForm->isValid()) {
            $userSubscriberCourseFormData = $userSubscriberCourseForm->getData();
            
            // Add the user 'learner' to the course
            $courseRepository->addLearnerToCourse(
                $userSubscriberCourseFormData['user_id'],
                $userSubscriberCourseFormData['course_id']
            );
        }

        // Retrieve the course from the database
        $course = $courseRepository->findBy(['slug' => $slug]);

        // Retrieve the sections from the database by the course
        $sections = $course[0]->getSections();
        $sectionsValues = $sections->getValues();

        // Ckeck if the user is enrolled in the course
        $user = $this->getUser(); 
        $learners = $course[0]->getLearners()->getValues();
        
        // If the course have learners, check if the user is enrolled in the course
        if (!empty($learners)) {
            foreach ($learners as $learner) {
                if ($learner->getId() === $user->getId()) {
                    $isEnrolled = true;
                }
            }
        } else {
            $isEnrolled = false;
        }

        // If sections array is empty, redirect to the course page with some null values
        if (empty($sections)) {
            return $this->render('course/show.one.html.twig', [
                'course' => $course[0],
                'sections' => null,
                'lessons' => null,
                'isEnrolled' => $isEnrolled,
                'user_subscriber_course_form' => $userSubscriberCourseForm->createView(),
            ]);
        // If sections array is fullfilled, check if it have some lessons
        } else {
            foreach ($sectionsValues as $section) {
                $lessons[] = $section->getLessons();
            }

            // If the lessons array isn't empty, return the course page with the lessons
            if (!empty($lessons)) {
                foreach ($lessons as $lesson) {
                    $lessonsValues[] = $lesson->getValues();
                }
            } else {
                $lessonsValues = null;
            }

            return $this->render('course/show.one.html.twig', [
                'course' => $course[0],
                'sections' => $sectionsValues,
                'lessons' => $lessonsValues,
                'isEnrolled' => $isEnrolled,
                'user_subscriber_course_form' => $userSubscriberCourseForm->createView(),
            ]);
        }
    }
}
