<?php

namespace App\DataFixtures;

use App\Entity\Tutorial;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TutorialFixtures extends Fixture
{
    public const TUTORIALS = [
            'Utiliser Blue Line',
            'Utiliser son téléphone',
            'Naviguer dans une application',
            'Naviguer dans Blue Line',
    ];
    public function load(ObjectManager $manager): void
    {
        foreach (self::TUTORIALS as $key => $tutorialName) {
            $tutorial = new Tutorial();
            $tutorial->setTitle($tutorialName);
            $manager->persist($tutorial);
            $this->addReference('tutorial_' . $key, $tutorial);

            $manager->flush();
        }
    }
}
