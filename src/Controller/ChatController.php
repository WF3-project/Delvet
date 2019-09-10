<?php

namespace App\Controller;

use App\Entity\Messages;
use App\Form\MessagesType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

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

    /**
     * @Route("/chat/messages", name="chat_view")
     */
    public function getMessages(SerializerInterface $serializer)
    {
        $messages = $this->getDoctrine()->getRepository(Messages::class)->findAll();
        $json = $serializer->serialize(
            $messages,
            'json'
        );
        return new Response( $json );
    }

    /**
     * @Route("/chat/addmessage", name="chat_update")
     */
    public function addMessage(Request $request)
    {
        $message= new Messages();
        $form = $this->createForm(MessagesType::class, $message);
        $form->submit( array(
            'author' => $this->getUser()->getEmail(),
            'content' => $request->request->get('content'),
        ));
        
        if ( $form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($message);
            $entityManager->flush();
        
            return new JsonResponse( array(
                'status' => true
            ));
        }
        return new JsonResponse( array(
            'status' => false
        ));
        
    }
    
}
