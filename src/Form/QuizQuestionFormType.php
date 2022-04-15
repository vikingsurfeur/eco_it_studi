<?php

namespace App\Form;

use App\Entity\QuizAnswerChoice;
use App\Entity\QuizQuestion;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuizQuestionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('questionDescription', TextType::class, [
                'label' => 'Question',
            ])
            ->add('quizAnswerChoices', EntityType::class, [
                'class' => QuizAnswerChoice::class,
                'choice_label' => 'choiceDescription',
                'multiple' => true,
                'expanded' => true,
                'label' => false,
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
