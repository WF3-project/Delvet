<?php

namespace App\DataFixtures;

use App\Entity\Courses;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CoursesFixtures extends Fixture
{
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
        $manager->persist($course);
        }
        $manager->flush();
    }
}
