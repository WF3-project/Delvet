<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ChatController extends AbstractController
{
    /**
     * @Route("/chat", name="chat")
     */
    public function index()
    {
        return $this->render('chat/index.html.twig', [
            'controller_name' => 'ChatController',
        ]);
    }
    //1. Création d'une fonction pour générer la route depuis un twig ( a peu près = include)

    //2. Création d'une fonction pour load les messages depuis la BDD

    //3. Création d'une fonction pour l'envoi des messages 

}

