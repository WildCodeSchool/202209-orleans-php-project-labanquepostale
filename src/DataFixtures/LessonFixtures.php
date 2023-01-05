<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Tutorial;
use App\Entity\Lesson;
use App\DataFixtures\TutorialFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class LessonFixtures extends Fixture implements DependentFixtureInterface
{
    public const LESSONS = [
        'Utiliser Blue Line',
        'Allumer son téléphone',
        'Gérer sa batterie',
        'Activer les notifications'
    ];

    public const VIDEO = [
        'https://www.youtube.com/embed/Cm63VfyL5BQ',
        'https://www.youtube.com/embed/tyqS8KUMdzI',
        'https://www.youtube.com/embed/oFLU2szBJNw',
        'https://www.youtube.com/embed/oFLU2szBJNw',
    ];

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < count(TutorialFixtures::TUTORIALS); $i++) {
            foreach (self::LESSONS as $lessonKey => $lessonName) {
                $lesson = new Lesson();
                $lesson->setTitle($lessonName);
                $lesson->setDescription(($faker->paragraphs(1, true)));
                $lesson->setVideo(self::VIDEO[$lessonKey]);
                $tutorial = $this->getReference('tutorial_' . $i);
                $lesson->setTutorial($tutorial);
                $manager->persist($lesson);
                $this->addReference('tutorial_' . $i . '_lesson_' . $lessonKey, $lesson);
            }
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            TutorialFixtures::class
        ];
    }
}
