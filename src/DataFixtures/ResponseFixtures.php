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
            'Vrai, si l\icône de la batterie est en rouge',
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

    public const NB_ANSWERS = 4;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($tutoKey = 0; $tutoKey < count(TutorialFixtures::TUTORIALS); $tutoKey++) {
            for ($i = 0; $i < count(QuestionFixtures::QUESTIONS); $i++) {
                for ($j = 0; $j < count(QuestionFixtures::QUESTIONS[$i]); $j++) {
                    for ($k = 0; $k < self::NB_ANSWERS; $k++) {
                        $response = new Explanation();
                        if ($k == 1) {
                            $response->setIsCorrect(true);
                        } else {
                            $response->setIsCorrect(false);
                        }
                        if ($i == 2) {
                            foreach (self::ANSWERS as $k => $answer) {
                                $response->setAnswer($answer);
                            }
                        } else {
                            $response->setAnswer($faker->sentence(3, true));
                        }
                        $question = $this->getReference('tutorial_' . $tutoKey . '_lesson_' . $i . '_question_' . $j);
                        $response->setQuestion($question);
                        $manager->persist($response);
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
