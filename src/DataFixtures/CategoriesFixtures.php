<?php

namespace App\DataFixtures;
use App\Entity\Categories;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

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
        $categorie->setName('nom du categories');
        $manager->persist($categorie);
        $categories[]=$categorie;
        }
        $manager->flush();
    }
}
