<?php

namespace App\DataFixtures;

use App\Entity\Question;
use App\DataFixtures\LessonFixtures;
use App\DataFixtures\TutorialFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class QuestionFixtures extends Fixture implements DependentFixtureInterface
{
    public const QUESTIONS = [
        [
            'Je dois créer un compte pour utiliser l\'application.',
            'Je dois valider le quiz pour voir les autres leçons.',
            'Combien y\'a t-il de tutoriels dans Blue Line ?',
        ],
        [
            'Éteindre son téléphone, c\'est le mettre en veille.',
            'Mon téléphone est en silencieux : est-il éteint ?',
        ],
        [
            'Je ne peux pas allumer mon téléphone s\'il charge.',
            'Qu\'est-ce qui ne permet PAS d\'économiser de la batterie ?',
            'Quelle option n\'existe pas ?',
        ],
        [
            'Je ne peux pas allumer mon téléphone s\'il charge.',
            'Augmenter la luminosité consomme plus de batterie.',
            'La performance de la batterie diminue avec le temps.',
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < count(TutorialFixtures::TUTORIALS); $i++) {
            for ($lessonKey = 0; $lessonKey < count(LessonFixtures::LESSONS); $lessonKey++) {
                foreach (self::QUESTIONS[$lessonKey] as $j => $questionText) {
                    $question = new Question();
                    $question->setQuestionText($questionText);
                    $lesson = $this->getReference('tutorial_' . $i . '_lesson_' . $lessonKey);
                    $question->setLesson($lesson);
                    $manager->persist($question);
                    $this->addReference('tutorial_' . $i . '_lesson_' . $lessonKey . '_question_' . $j, $question);
                }
            }
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            LessonFixtures::class
        ];
    }
}
