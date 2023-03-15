<?php

namespace App\Form;

use App\Entity\Question;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnswerQuestionnaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $question = $options['question'];

        $builder
            ->add('reponses', $question->getTypeQuestion() === 'Multiple' ? CheckboxType::class : ChoiceType::class, [
                'label' => $question->getNomQuestion(),
                'choices' => $question->getReponses(),
                'choice_label' => 'nomReponse',
                'choice_value' => 'id',
                'mapped' => false,
                'required' => true,
                'expanded' => $question->getTypeQuestion() === 'checkbox',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('question');
    }
}

