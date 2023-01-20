<?php

namespace App\Form;

use App\Entity\Lesson;
use App\Entity\Tutorial;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Validator\Constraints\NotBlank;

class Lesson1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class)
            ->add('description', TextType::class)
            ->add('video', UrlType::class, [
                'label' => 'Vidéo'
            ])
            ->add('tutorial', EntityType::class, [
                'class' => Tutorial::class,
                'label' => 'Tutoriel',
                'choice_label' => 'title',
                'multiple' => false,
                'expanded' => true,
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Choisissez un tutoriel'
                    ])
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Lesson::class,
        ]);
    }
}
