<?php

namespace App\DataFixtures;

use App\Entity\Lesson;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;

class LessonFixtures extends Fixture
{
    public const LESSONS = [
        'Utiliser Blue Line',
        'Allumer son téléphone',
        'Gérer sa batterie',
    ];

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        foreach (self::LESSONS as $lessonKey => $lessonName) {
            $lesson = new Lesson();
            $lesson->setTitle($lessonName);
            $lesson->setDescription(($faker->paragraphs(1, true)));
            $manager->persist($lesson);
            $this->addReference('lesson_' . $lessonKey, $lesson);
        }
        $manager->flush();
    }
}
