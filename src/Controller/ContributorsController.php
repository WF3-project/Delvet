<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Contributors;
use App\Repository\ContributorsRepository;
use Symfony\Component\HttpFoundation\Response;

class ContributorsController extends AbstractController
{   

    
    /**
     * @Route("/contributors", name="contributors")
     */
    public function index(contributorsRepository $contributorsRepository)
    {
        $user=[];
        $contributors=$contributorsRepository->findAll();
       
        
        dump($contributors);
        return $this->render('contributors/index.html.twig', [
            'contributors' => $contributorsRepository->findAll(),
           
        ]);
    }
    
}
