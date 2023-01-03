<?php

namespace App\DataFixtures;

use App\Entity\Question;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class QuestionFixtures extends Fixture implements DependentFixtureInterface
{
    public const QUESTIONS = [
        [
            'Je dois créer un compte pour utiliser l\'application',
            'Je dois valider le quiz pour voir les autres leçons',
            'Combien y\'a t-il de tutoriels dans Blue Line ?',
        ],
        [
            'Éteindre son téléphone, c\'est le mettre en veille',
            'Mon téléphone est en silencieux : est-il éteint ?',
        ],
        [
            'Je ne peux pas allumer mon téléphone s\'il charge',
            'Augmenter la luminosité consomme plus de batterie',
            'La performance de la batterie diminue avec le temps',
        ],
        [
            'Je ne peux pas allumer mon téléphone s\'il charge',
            'Augmenter la luminosité consomme plus de batterie',
            'La performance de la batterie diminue avec le temps',
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < count(LessonFixtures::LESSONS); $i++) {
            foreach (self::QUESTIONS[$i] as $j => $questionText) {
                $question = new Question();
                $question->setQuestionText($questionText);
                $lesson = $this->getReference('_lesson_' . $i);
                $question->setLesson($lesson);
                $manager->persist($question);
                $this->addReference('_lesson_' . $i . '_question_' . $j, $question);
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
