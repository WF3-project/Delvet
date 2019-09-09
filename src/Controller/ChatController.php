<?php

namespace App\Controller;

use App\Entity\Messages;
use App\Form\MessagesType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    public function getMessages(Messages $message)
    {
        return $this->render('chat/index.html.twig', [
            'message' => $message,
        ]);

        echo json_encode($message);
    }

    public function addMessage(Request $request, Messages $message)
    {
        new Messages();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($message);
            $entityManager->flush();

            return $this->redirectToRoute('messages');
        }
        return $this->render('chat/index.html.twig', [
            'message' => $message,
        ]);
    }
    
}
