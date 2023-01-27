<?php

namespace App\Service;

use App\Repository\ExplanationRepository;
use Exception;

class CheckGoodAnswer
{
    public const EXPECTED_SCORE =  (1 / 3) * 2;

    public function __construct(private ExplanationRepository $explanationRepo)
    {
    }

    public function checkQuizz(array $questions): bool
    {
        $goodAnswers = 0;

        if (count($questions) === 0) {
            throw new Exception('Pas de questions sur ce quizz');
        }

        foreach ($questions as $question) {
            $answer = $this->explanationRepo->find($question['response']);
            if ($answer->isIsCorrect() === true) {
                $goodAnswers++;
            }
        }

        return $goodAnswers / count($questions) >= self::EXPECTED_SCORE;
    }
}
