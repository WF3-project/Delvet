<?php

namespace App\DataFixtures;
use App\Entity\Categories;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Cocur\Slugify\Slugify;

class CategoriesFixtures extends Fixture implements FixtureGroupInterface
{
    public static function getGroups(): array
     {
         return ['Categories'];
     }

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
        $manager->flush();
    }
}
