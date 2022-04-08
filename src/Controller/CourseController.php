<?php

namespace App\Controller;

use App\Entity\Progress;
use App\Form\UserSubscriberCourseType;
use App\Repository\CourseRepository;
use App\Repository\LessonRepository;
use App\Repository\ProgressRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

class CourseController extends BaseController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    // COURSES LIST
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

    // COURSES DETAILS + SUBSCRIBE
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

        // Retrieve the progress of the user
        $userProgress = $this->getUser()->getProgress();

        if (!empty($userProgress)) {
            $userProgressValues = $userProgress->getValues();
            $currentCoursesProgress = [];
            // Find the right user's progress for the current course
            foreach ($userProgressValues as $userProgressValue) {
                $currentCoursesProgress[] = $userProgressValue->getCourses();
            }
            $currentCoursesProgressValues = [];
            foreach ($currentCoursesProgress as $currentCoursesProgressValue) {
                $currentCoursesProgressValues[] = $currentCoursesProgressValue->getValues();
            }
            foreach ($currentCoursesProgressValues as $currentCoursesProgressValue) {
                if ($currentCoursesProgressValue[0]->getId() === $course[0]->getId()) {
                    $currentUserProgress = $currentCoursesProgressValue[0];
                    $currentUserProgressValues = $currentUserProgress->getProgress()->getValues();
                }
            }
        } else {
            $userProgress = null;
        }
        

        // If sections array is empty, redirect to the course page with some null values
        if (empty($sections)) {
            return $this->render('course/show.one.html.twig', [
                'course' => $course[0],
                'sections' => null,
                'lessons' => null,
                'userProgress' => $currentUserProgressValues[0] ?? null,
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
                'userProgress' => $currentUserProgressValues[0] ?? null,
                'user_subscriber_course_form' => $userSubscriberCourseForm->createView(),
            ]);
        }
    }

    // SUBSCRIBE TO COURSE
    #[Route('/course/{slug}/subscribe', name: 'app_course_subscribe')]
    public function userSubscriberCourse(
        CourseRepository $courseRepository,
        ProgressRepository $progressRepository,
        Request $request,
        string $slug
    ): Response
    {
         // Render the user subscription form
         $userSubscriberCourseForm = $this->createForm(UserSubscriberCourseType::class);
         $userSubscriberCourseForm->handleRequest($request);
 
         // Form action user subscription
         if ($userSubscriberCourseForm->isSubmitted() && $userSubscriberCourseForm->isValid()) {
            $userSubscriberCourseFormData = $userSubscriberCourseForm->getData();

            // Add the user 'learner' to the course
            $courseRepository->addLearnerToCourse(
                $userSubscriberCourseFormData['user_id'],
                $userSubscriberCourseFormData['course_id']
            );
            
            // Set the progress of the user
            // First step, find all sections / lessons of the course
            $course = $courseRepository->findOneBy(['slug' => $slug]);
            $sections = $course->getSections();
            if (!empty($sections)) {
                foreach ($sections as $section) {
                    $lessons = $section->getLessons();
                }
            }

            // Second step, create a progress for the user for this course
            $progress = new Progress();
            $progress->addUser($this->getUser());
            $progress->addCourse($course);

            foreach ($sections as $section) {
                $progress->addSection($section);
            };

            if (!empty($lessons)) {
                foreach ($lessons as $lesson) {
                    $progress->addLesson($lesson);
                }
            }

            // Third step, set all the properties of the progress to false
            $progress->setCourseFinished(false);
            $progress->setSectionFinished(false);
            $progress->setLessonFinished(false);

            // Save the progress
            $progressRepository->add($progress);

            // Return JSON response
            return $this->json([
                'status' => 'success',
                'message' => 'Félicitations, vous êtes maintenant inscrit à ce cours.
                    Rendez-vous sur la page "Mes cours" pour commencer à apprendre.
                ',
            ]);
        }

        // Return error JSON response
        return $this->json([
            'status' => 'error',
            'message' => 'Une erreur est survenue lors de la souscription au cours.',
        ]);
    }

    // LESSON FINISHED CHECK
    #[Route('/course/{slug}/lesson/{lessonId}/finished', name: 'app_course_lesson_finished')]
    public function lessonFinisherCheck(
        LessonRepository $lessonRepository,
        Request $request,
        int $lessonId,
    ): Response
    {   
        if ($request->getMethod() === 'POST') {
            $lesson = $lessonRepository->findOneBy(['id' => $lessonId]);
            $lesson->setIsFinished(true);
            $this->entityManager->flush();
            
            return $this->json([
                'status' => 'success',
                'message' => 'Vous avez terminé la leçon',
            ]);
        }

        return $this->json([
            'status' => 'error',
            'message' => 'Une erreur est survenue',
        ]);
    }
}
