<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use App\Entity\Courses;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Cocur\Slugify\Slugify;


class CoursesFixtures extends Fixture  implements FixtureGroupInterface

{
    public static function getGroups(): array
     {
         return ['Courses'];
     }


    public function __construct()
    {}
    

   

    public function load(ObjectManager $manager)
    {

        $categories = [];

        for($i=0;$i<=5;$i++)
        {
        $categorie=new Categories();
        $name=$categorie->setName('nom de la categories')->getName();
        $slugify=new Slugify();
        $slug = $slugify->slugify($name);
        $categorie->setSlug( $slug );   
        $manager->persist($categorie);
        $categories[]=$categorie;
        }

       $courses=[];
        for($i=0;$i<=5;$i++)
        {
        $course=new Courses();
        $course->setName('nom du cour');
        $course->setDescription('un cour');
        $course->setImage('une immage');
        $course->setDateCreate(new DateTime());
        $course->setNumberView(rand(0 , 1000));
        $categorie_cour=rand(0, count($categories));
        $course->setCategories($categories[$categorie_cour]);
        $manager->persist($course);
        $courses[]=$course;
        }
        $manager->flush();
    }
}
