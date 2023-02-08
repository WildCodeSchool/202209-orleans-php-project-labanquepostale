<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Explanation;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ResponseFixtures extends Fixture implements DependentFixtureInterface
{
    public const ANSWERS = [
        [
            'Vrai',
            'Faux',
            'Vrai, si l\'icône de la batterie est en rouge',
        ],
        [
            'Baisser la luminosité',
            'Désactiver l\'accès au wifi',
            'Désactiver la géolocalisation',
        ],
        [
            'La luminosité automatique',
            'La désactivation automatique des données',
            'Le verrouillage automatique',
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < count(TutorialFixtures::TUTORIALS); $i++) {
            for ($j = 0; $j < count(LessonFixtures::LESSONS); $j++) {
                for ($k = 0; $k < count(QuestionFixtures::QUESTIONS[$j]); $k++) {
                    if ($j == 2) {
                        foreach (self::ANSWERS[$k] as $key => $answerText) {
                            $response = new Explanation();
                            $response->setIsCorrect(false);
                            $response->setAnswer($answerText);
                            if ($key == 1) {
                                $response->setIsCorrect(true);
                            }
                            $question = $this->getReference('tutorial_' . $i . '_lesson_' . $j . '_question_' . $k);
                            $response->setQuestion($question);
                            $manager->persist($response);
                        }
                    } else {
                        for ($k = 0; $k < count(self::ANSWERS[$k]); $k++) {
                            $response = new Explanation();
                            $response->setAnswer($faker->sentence(3, true));
                            $response->setIsCorrect(false);
                            if ($k == 1) {
                                $response->setIsCorrect(true);
                            }
                            $question = $this->getReference('tutorial_' . $i . '_lesson_' . $j . '_question_' . $k);
                            $response->setQuestion($question);
                            $manager->persist($response);
                        }
                    }
                }
            }
            $manager->flush();
        }
    }

    public function getDependencies()
    {
        return [
            QuestionFixtures::class
        ];
    }
}
