<?php

namespace App\Form;

use App\Entity\Quiz;
use App\Entity\QuizAnswerChoice;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;

class QuizFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $quiz = $options['quiz'];
        foreach($quiz->getQuizQuestions() as $quizQuestion) {
            $builder
                ->add('question_'.$quizQuestion->getId(), EntityType::class, [
                    'label' => $quizQuestion->getQuestionDescription(),
                    'class' => QuizAnswerChoice::class,
                    'multiple' => true,
                    'expanded' => true,
                    'query_builder' => function (EntityRepository $er) use ($quizQuestion) {
                        return $er->createQueryBuilder('q')
                        ->where('q.quizQuestions = :quizQuestion')
                        ->setParameter('quizQuestion', $quizQuestion);
                    },
                    'choice_label' => function (QuizAnswerChoice $quizAnswerChoice) {
                        return $quizAnswerChoice->getChoiceDescription();
                    },
                    'choice_attr' => function (QuizAnswerChoice $quizAnswerChoice) {
                        return ['data-correct-answer' => $quizAnswerChoice->getIsCorrectAnswer() ? 'true' : 'false'];
                    },
                ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'quiz' => null,
        ]);

        $resolver->setAllowedTypes('quiz', Quiz::class);
    }
}
