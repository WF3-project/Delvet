<?php

namespace App\Controller;

use App\Repository\MessagesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Messages;

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
    public function getMessages(MessagesRepository $messagesRepository)
    {
        return $this->render('chat/index.html.twig', [
        'messages' => $messagesRepository->findAll()
        ]);
    }
    //3. Création d'une fonction pour l'envoi des messages 
    /**
     * @Route("/chat", name="chat")
     */
    public function sendMessages(Request $request)
    {
        $message= new Messages();
        $form = $this->createForm(MessagesType::class, $message);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            // On récupere Doctrine pour gérer la BDD
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($message);
            $entityManager->flush();
        }
    }
}

