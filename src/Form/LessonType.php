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

class LessonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('tutorial', EntityType::class, [
                'class' => Tutorial::class,
                'label' => 'Tutoriel',
                'choice_label' => 'title',
                'multiple' => false,
                'expanded' => true,
            ])
            ->add('title', TextType::class, [
                'label' => 'Titre'
            ])
            ->add('description', TextType::class)
            ->add('video', UrlType::class, [
                'label' => 'Vidéo'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Lesson::class,
        ]);
    }
}
