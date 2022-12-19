<?php

namespace App\DataFixtures;

use App\Entity\Lesson;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;

class LessonFixtures extends Fixture
{
    public const TITLES = [
        'Utiliser Blue Line',
        'Allumer son téléphone',
        'Gérer sa batterie',
        'Activer les notifications'
    ];

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        foreach (self::TITLES as $lessonName) {
            $lesson = new Lesson();
            $lesson->setTitle($lessonName);
            $lesson->setDescription(($faker->paragraphs(1, true)));
            $manager->persist($lesson);
        }
        $manager->flush();
    }
}
