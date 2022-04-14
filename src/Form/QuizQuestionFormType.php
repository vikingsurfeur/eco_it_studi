<?php

namespace App\Form;

use App\Entity\QuizQuestion;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuizQuestionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var QuizAnswerChoice $answers */
        $answers = $options['quizAnswerChoices'];

        $builder
            ->add('selectedAnswer', EntityType::class, [
                'class' => QuizAnswerChoice::class,
                'choices' => $answers,
                'choice_label' => 'choiceDescription',
                'expanded' => true,
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => QuizQuestion::class,
        ]);
    }
}
