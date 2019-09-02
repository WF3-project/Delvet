<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CoursesController extends AbstractController
{
    /**
     * @Route("/cour", name="cour")
     */
    public function listcours(CourRepository $courRepository)
    {   
        $cours = $courRepository->findAll();
        dump($cours);
        return $this->render('cour/index.html.twig',[
            'cours' => $cours,
        ]);
    }
}
