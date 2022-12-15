<?php

namespace App\DataFixtures;

use App\Entity\Question;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class QuestionFixtures extends Fixture
{
    public const TESTS =
    [
        'Je peux allumer mon téléphone s\'il charge :',
        'Augmenter la luminosité consomme plus de batterie :',
        'Je donne mon numéro de sécurité sociale si on me le demande par mail :'
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::TESTS as $test) {
            $question = new Question();
            $question->setTest($test);
            $manager->persist($question);
        }
        $manager->flush();
    }
}
