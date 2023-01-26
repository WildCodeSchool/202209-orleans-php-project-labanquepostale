<?php

namespace App\Twig\Components;

use App\Entity\Question;
use App\Form\QuestionType;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\LiveCollectionTrait;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[AsLiveComponent('_form_collection_question')]
final class AdminQuizComponent extends AbstractController
{
    use DefaultActionTrait;
    use LiveCollectionTrait;

    #[LiveProp(fieldName: '')]
    public ?Question $quizQuestion = null;

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(
            QuestionType::class,
            $this->quizQuestion
        );
    }
}
