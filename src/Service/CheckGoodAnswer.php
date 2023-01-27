<?php

namespace App\Service;

use App\Repository\ExplanationRepository;

class CheckGoodAnswer
{
    public int $goodAnswers;
    public const EXPECTED_SCORE =  (1 / 3) * 2;

    public function __construct(private ExplanationRepository $explanationRepo)
    {
        $this->explanationRepo = $explanationRepo;
        $this->goodAnswers = 0;
    }

    public function checkQuizz(array $questions): bool
    {
        $goodAnswers = 0;

        foreach ($questions as $question) {
            $answer = $this->explanationRepo->find($question['response']);
            if ($answer->isIsCorrect() === true) {
                $goodAnswers++;
            }
        }
        return $goodAnswers / count($questions) >= self::EXPECTED_SCORE;
    }
}
