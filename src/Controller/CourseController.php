<?php

namespace App\Controller;

use App\Entity\CourseProgressState;
use App\Entity\LessonProgressState;
use App\Entity\Progress;
use App\Entity\SectionProgressState;
use App\Form\UserSubscriberCourseType;
use App\Repository\CourseProgressStateRepository;
use App\Repository\CourseRepository;
use App\Repository\LessonProgressStateRepository;
use App\Repository\LessonRepository;
use App\Repository\ProgressRepository;
use App\Repository\SectionProgressStateRepository;
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

    // COURSE SINGLE DETAILS
    #[Route('/course/{slug}', name: 'app_course_show_slug')]
    public function showOne(
        CourseRepository $courseRepository,
        CourseProgressStateRepository $courseProgressStateRepository,
        SectionProgressStateRepository $sectionProgressStateRepository,
        LessonProgressStateRepository $lessonProgressStateRepository,
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

        if (!empty($sections)) {
            $sectionsValues = $sections->getValues();
        }

        // Retrieve the lessons from the database by the sections
        if (!empty($sectionsValues)) {
            foreach ($sectionsValues as $section) {
                $lessons = $section->getLessons();
                $lessonsValues[] = $lessons->getValues();
            }
        }
 
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

        // Retrieve the progress State of the Course by the user
        $courseProgressState = $courseProgressStateRepository->findByCourseAndUser(
            $course[0]->getId(), 
            $this->getUser()->getId()
        );
        
        // Retrieve the progress State of the Sections by the user
        $sectionsProgressStates = [];
        foreach ($sectionsValues as $section) {
            $sectionsProgressStates[] = $sectionProgressStateRepository->findBySectionAndUser(
                $section->getId(), 
                $this->getUser()->getId()
            );
        }
        
        // Retrieve the progress State of the Lessons by the user
        $lessonsProgressStates = [];
        if (!empty($lessonsValues)) {
            foreach ($lessonsValues as $lessonValue) {
                foreach ($lessonValue as $lesson) {
                    $lessonsProgressStates[] = $lessonProgressStateRepository->findByLessonAndUser(
                        $lesson->getId(), 
                        $this->getUser()->getId()
                    );
                }
            }
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
        }

        return $this->render('course/show.one.html.twig', [
            'course' => $course[0],
            'courseProgressState' => $courseProgressState,
            'sections' => $sectionsValues,
            'sectionsProgressStates' => $sectionsProgressStates,
            'lessons' => $lessonsValues ?? null,
            'lessonsProgressStates' => $lessonsProgressStates,
            'userProgress' => $currentUserProgressValues[0] ?? null,
            'isEnrolled' => $isEnrolled ?? null,
            'user_subscriber_course_form' => $userSubscriberCourseForm->createView(),
        ]);
    }   

    // SUBSCRIBE TO COURSE
    #[Route('/course/{slug}/subscribe', name: 'app_course_subscribe')]
    public function userSubscriberCourse(
        CourseRepository $courseRepository,
        ProgressRepository $progressRepository,
        CourseProgressStateRepository $courseProgressStateRepository,
        SectionProgressStateRepository $sectionProgressStateRepository,
        LessonProgressStateRepository $lessonProgressStateRepository,
        Request $request,
        string $slug
    ): Response
    {
         // Render the user subscription form
         $userSubscriberCourseForm = $this->createForm(UserSubscriberCourseType::class);
         $userSubscriberCourseForm->handleRequest($request);
 
         // Form action user subscription
         if ($userSubscriberCourseForm->isSubmitted() && $userSubscriberCourseForm->isValid()) {
             // Retrieve data from the form
            $userSubscriberCourseFormData = $userSubscriberCourseForm->getData();
            
            /***** Set the progress of the user *****/
            /***** Set the progressStates of Course, Sections and Lessons *****/
            // First step, find all sections / lessons of the course
            $course = $courseRepository->findOneBy(['slug' => $slug]);
            
            // Second step, create a progress for the user for this course and ProgressStates for each section / lesson and this course
            $userProgress = new Progress();
            $userProgress->addUser($this->getUser());
            $userProgress->addCourse($course);
            
            $courseProgressState = new CourseProgressState();
            $courseProgressState->setCourse($course);
            $courseProgressState->setUser($this->getUser());

            $sections = $course->getSections();
            $sectionsProgressStates = [];
            $lessons = [];

            if (!empty($sections)) {
                foreach ($sections as $section) {
                    $userProgress->addSection($section);

                    $lessons[] = $section->getLessons();

                    $sectionProgressState = new SectionProgressState();
                    $sectionProgressState->setSection($section);
                    $sectionProgressState->setUser($this->getUser());
                    array_push($sectionsProgressStates, $sectionProgressState);
                }
            }

            $lessonsProgressStates = [];
            $lessonsValues = [];

            if (!empty($lessons)) {
                foreach ($lessons as $lesson) {
                    $lessonsValues[] = $lesson->getValues();
                }
            }

            foreach ($lessonsValues as $lessonValue) {
                foreach ($lessonValue as $lesson) {
                    $userProgress->addLesson($lesson);

                    $lessonProgressState = new LessonProgressState();
                    $lessonProgressState->setLesson($lesson);
                    $lessonProgressState->setUser($this->getUser());
                    array_push($lessonsProgressStates, $lessonProgressState);
                }
            }
            
            
            // Third step, set all the properties of the progress and the progressState to false
            $userProgress->setCourseFinished(false);
            $userProgress->setSectionFinished(false);
            $userProgress->setLessonFinished(false);

            // Add the user Progress to the database
            $progressRepository->add($userProgress);

            // Add the course ProgressState to the database
            $courseProgressStateRepository->add($courseProgressState);

            // Add the section ProgressStates to the database
            foreach ($sectionsProgressStates as $sectionProgressState) {
                $sectionProgressStateRepository->add($sectionProgressState);
            }

            // Add the lesson ProgressStates to the database
            foreach ($lessonsProgressStates as $lessonProgressState) {
                $lessonProgressStateRepository->add($lessonProgressState);
            }

            // Add the user 'learner' to the course
            $courseRepository->addLearnerToCourse(
                $userSubscriberCourseFormData['user_id'],
                $userSubscriberCourseFormData['course_id']
            );

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
        LessonProgressStateRepository $lessonProgressStateRepository,
        SectionProgressStateRepository $sectionProgressStateRepository,
        CourseProgressStateRepository $courseProgressStateRepository,
        Request $request,
        int $lessonId,
    ): Response
    {   
        if ($request->getMethod() === 'POST') {
            // Retrieve the lesson finished and set the state to true
            $lessonProgressStateFinished = $lessonProgressStateRepository->findByLessonAndUser(
                $lessonId, 
                $this->getUser()->getId()
            );
            $lessonProgressStateFinished->setState(true);
            $this->entityManager->flush();

            // Retrieve the parent section of the lesson finished
            $lesson = $lessonProgressStateFinished->getLesson();
            $parentSection = $lesson->getSection();

            // Retrieve the lessons of the parent section and the progressState of the lessons and the section
            $lessons = $parentSection->getLessons();
            
            $siblingLessonsProgressStates = [];
            foreach ($lessons as $lesson) {
                $lessonProgressState = $lessonProgressStateRepository->findByLessonAndUser(
                    $lesson->getId(),
                    $this->getUser()->getId()
                );
                array_push($siblingLessonsProgressStates, $lessonProgressState);
            }

            $parentSectionProgressState = $sectionProgressStateRepository->findBySectionAndUser(
                $parentSection->getId(), 
                $this->getUser()->getId()
            );

            // Loop on siblings lessons to check if all of them are finished
            foreach ($siblingLessonsProgressStates as $siblingLessonProgressState) {
                if ($siblingLessonProgressState->getState()) {
                    $parentSectionProgressState->setState(true);
                    $this->entityManager->flush();
                }
            }

            // Retrieve the parent course of the section
            $course = $parentSection->getCourse();

            // Retrieve the sections of the parent course
            $sections = $course->getSections();

            // Retrieve the progressStates of the course, section and lesson
            $courseProgressState = $courseProgressStateRepository->findByCourseAndUser(
                $course->getId(),
                $this->getUser()->getId()
            );

            $sectionsProgressStates = [];
            foreach ($sections as $section) {
                $sectionProgressState = $sectionProgressStateRepository->findBySectionAndUser(
                    $section->getId(),
                    $this->getUser()->getId()
                );
                array_push($sectionsProgressStates, $sectionProgressState);
            }

            // Check if all the sections of the parent course are finished and set the state to true if it is
            foreach ($sectionsProgressStates as $sectionProgressState) {
                if ($sectionProgressState->getState()) {
                    $courseProgressState->setState(true);
                    $this->entityManager->flush();
                }
            }

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
