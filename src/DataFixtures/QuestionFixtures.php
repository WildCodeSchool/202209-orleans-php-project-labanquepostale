<?php

namespace App\DataFixtures;

use App\Entity\Question;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class QuestionFixtures extends Fixture implements DependentFixtureInterface
{
    public const TESTS =
    [
        'Je peux éteindre mon téléphone s\'il charge ?',
        'Augmenter la luminosité consomme plus de batterie ?',
        'Je donne mon numéro de sécurité sociale si on me le demande par mail ?'
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::TESTS as $test) {
            $question = new Question();
            $question->setTest($test);
            foreach (LessonFixtures::TITLES as $lessonName) {
                $lesson = $this->getReference('lesson_Utiliser Blue Line');
            }
            $question->setLesson($lesson);
            $manager->persist($question);
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
