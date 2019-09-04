<?php

namespace App\DataFixtures;

use App\Entity\Courses;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;


class CoursesFixtures extends Fixture  implements FixtureGroupInterface

{
    public static function getGroups(): array
     {
         return ['Courses'];
     }


    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {

    
        for($i=0;$i<=5;$i++)
        {
        $course=new Courses();
        $course->setName('nom du cour');
        $course->setDescription('un cour');
        $course->setImage('une immage');
        $course->setDateCreate(new DateTime());
        $manager->persist($course);
        }
        $manager->flush();
    }
}
