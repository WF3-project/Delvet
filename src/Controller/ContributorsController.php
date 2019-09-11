<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ContributorsController extends AbstractController
{
    /**
     * @Route("/contributors", name="contributors")
     */
    public function index()
    {
        return $this->render('contributors/index.html.twig', [
            'controller_name' => 'ContributorsController',
        ]);
    }
}
