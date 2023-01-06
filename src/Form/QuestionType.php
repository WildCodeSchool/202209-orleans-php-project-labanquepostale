<?php

namespace App\Form;

use App\Entity\Question;
use App\Entity\Response;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $question = $event->getData();
            $form = $event->getForm();

            $form->add('response', EntityType::class, [
                'class' => Response::class,
                'label' => false,
                'choice_label' => 'answer',
                'multiple' => false,
                'expanded' => true,
                'mapped' => false,
                'query_builder' => function (EntityRepository $er) use ($question) {
                    return $er->createQueryBuilder('r')
                        ->where('r.question=' . $question->getId());
                },
            ]);
        });
    }
}
