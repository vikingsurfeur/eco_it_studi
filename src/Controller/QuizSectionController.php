<?php

namespace App\Controller;

use App\Entity\UserQuizResult;
use App\Form\QuizFormType;
use App\Repository\QuizRepository;
use App\Repository\SectionRepository;
use App\Repository\UserQuizResultRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuizSectionController extends BaseController
{   
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/quiz/section/{id}', name: 'app_quiz_section')]
    public function index(
        int $id,
        SectionRepository $sectionRepository,
        QuizRepository $quizRepository,
    ): Response
    {
        if (!$this->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('app_login');
        }
        
        // Retrieve the section by his id
        $section = $sectionRepository->find($id);

        // Retrieve the quiz by his section id
        $quiz = $quizRepository->findOneBy(['section' => $section->getId()]);

        // Create the form with this quiz
        $formQuiz = $this->createForm(QuizFormType::class, null, [
            'quiz' => $quiz,
        ]);

        return $this->render('quiz_section/index.html.twig', [
            'quiz' => $quiz,
            'section' => $section,
            'form_quiz' => $formQuiz->createView(),
        ]);
    }

    // SUBMIT THE QUIZ AND DISPLAY THE RESULT
    #[Route('/quiz/section/{id}/submit/{quizId}', name: 'app_quiz_section_submit')]
    public function submitQuiz(
        Request $request,
        QuizRepository $quizRepository,
        UserQuizResultRepository $userQuizResultRepository,
        int $quizId,
    ): Response
    {
        if ($request->getMethod() === 'POST') {
            // Retrieve correctAnswer from request
            $dataRequest = json_decode($request->getContent());
            
            // Retrieve the correctAnswer and the falseAnswer key in dataRequest Object
            $correctAnswer = $dataRequest->correctAnswer;
            $falseAnswer = $dataRequest->falseAnswer;

            // Retrieve the quiz by his id
            $quiz = $quizRepository->find($quizId);
            
            // Retrieve the question by his quiz
            $questions = $quiz->getQuizQuestions();
            $questionsValues = $questions->getValues();

            // Count the number of questions
            $nbQuestions = count($questionsValues);

            // Calculate a percentage of good answers about the correctAnswer, the falseAnswer and the number of questions
            $percentage = (($nbQuestions - $falseAnswer) / $nbQuestions) * 100;
            $percentage < 0 && $percentage = 0;
            
            // Check if the user have already answered this quiz
            $userQuizResult = $userQuizResultRepository->findBy([
                'quiz' => $quizId, 
                'isResolvedBy' => $this->getUser()->getId()
            ]);

            // Create a userQuiz object
            if (empty($userQuizResult)) {
                $newUserQuizResult = new UserQuizResult();
                $newUserQuizResult = new UserQuizResult();
                $newUserQuizResult->setQuiz($quiz);
                $newUserQuizResult->setIsResolvedBy($this->getUser());
                $newUserQuizResult->setAnsweredAt(new \DateTime('now'));
                $newUserQuizResult->setNbGoodAnswer($correctAnswer);

                if ($percentage >= 50) {
                    $newUserQuizResult->setIsResolved(true);
                    $userQuizResultRepository->add($newUserQuizResult);

                    return $this->json([
                        'message' => 'Vous avez r??ussi le quiz !',
                        'status' => 'success',
                        'percentage' => $percentage,
                    ]);
                } else {
                    $newUserQuizResult->setIsResolved(false);
                    $userQuizResultRepository->add($newUserQuizResult);

                    return $this->json([
                        'message' => 'Vous n\'avez pas r??ussi le quiz !',
                        'status' => 'failed',
                        'percentage' => $percentage,
                    ]);
                }

            } else {
                $userQuizResult[0]->setNbGoodAnswer($correctAnswer);
                $userQuizResult[0]->setAnsweredAt(new \DateTime('now'));

                if ($percentage >= 50) {
                    $userQuizResult[0]->setIsResolved(true);
                    $this->entityManager->persist($userQuizResult[0]);
                    $this->entityManager->flush();

                    return $this->json([
                        'message' => 'Vous avez r??ussi le quiz !',
                        'status' => 'success',
                        'percentage' => $percentage,
                    ]);
                } else {
                    $userQuizResult[0]->setIsResolved(false);
                    $this->entityManager->persist($userQuizResult[0]);
                    $this->entityManager->flush();

                    return $this->json([
                        'message' => 'Vous n\'avez pas r??ussi le quiz !',
                        'status' => 'failed',
                        'percentage' => $percentage,
                    ]);
                }
            }
        }
    }
}
