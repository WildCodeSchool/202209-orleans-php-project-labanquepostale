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

    public const VIDEO = [
        'https://www.youtube.com/embed/Cm63VfyL5BQ',
        'https://www.youtube.com/embed/tyqS8KUMdzI',
        'https://www.youtube.com/embed/oFLU2szBJNw',
    ];

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        foreach (self::TITLES as $key => $lessonName) {
            $lesson = new Lesson();
            $lesson->setTitle($lessonName);
            $lesson->setDescription(($faker->paragraphs(1, true)));
            $lesson->setVideo(self::VIDEO[$key]);
            $manager->persist($lesson);
        }
        $manager->flush();
    }
}
