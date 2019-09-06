<?php

namespace App\Controller;
use App\Entity\User;
use App\Entity\Courses;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    
        public function coursesUser( UserRepository $userRepository)
        {     
            
            $user=$this->get('security.token_storage')->getToken()->getUser();
             
            if($user != 'anon.')
            {
                $Courses=$user->getCourse();
                return $this->render('user/index.html.twig', [
                    'user' => $userRepository->findByEmail($this->get('security.token_storage')->getToken()->getUser()->getEmail()),
                    'courses' => $Courses
                ]);

            }
            

          
            return $this->render('user/indexAnon.html.twig', [
                        'user' => $user
            ]);
            
        }
        
    
}
