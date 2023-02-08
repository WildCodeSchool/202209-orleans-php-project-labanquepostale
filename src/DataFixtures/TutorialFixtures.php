<?php

namespace App\DataFixtures;

use App\Entity\Tutorial;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TutorialFixtures extends Fixture
{
    public const TUTORIALS = [
            'Naviguer dans Blue Line',
            'Utiliser un smartphone',
            'Paramétrer son appareil',
            'Téléphoner',
            'Les SMS',
            'Les e-mails',
            'Naviguer sur internet',
            'Installer une application',
            'Se déplacer, se localiser',
            'Notions de sécurité',
            'Utiliser les réseaux sociaux',
            'Pour aller plus loin'

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
