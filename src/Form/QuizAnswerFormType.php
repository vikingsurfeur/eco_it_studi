<?php

namespace App\Form;

use App\Entity\QuizAnswerChoice;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuizAnswerFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('choiceDescription', TextType::class, [
                'label' => 'Réponse',
            ])
            ->add('isCorrectAnswer', CheckboxType::class, [
                'label' => 'Bonne réponse',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => QuizAnswerChoice::class,
        ]);
    }
}
