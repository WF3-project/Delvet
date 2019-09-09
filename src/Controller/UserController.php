<?php

namespace App\Controller;
use App\Entity\User;
use App\Entity\Courses;
use App\Repository\UserRepository;
use App\Repository\CoursesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    
        public function coursesUser( UserRepository $userRepository, CoursesRepository $coursesRepository )
        {     
            
            $user=$this->get('security.token_storage')->getToken()->getUser();
           
            dump($user);
                $courses=$coursesRepository->findLastCreatedAt();
            dump($userRepository->findByEmail($this->get('security.token_storage')->getToken()->getUser()->getEmail()));
            
            if($user != 'anon.')
            {
                $CoursesUser=$user->getCourse();
                
                dump($CoursesUser);
                return $this->render('user/index.html.twig', [
                    'user' => $userRepository->findByEmail($this->get('security.token_storage')->getToken()->getUser()->getEmail()),
                    'coursesUser' => $CoursesUser,
                    'courses'=> $courses
                ]);

            }
            

          
            return $this->render('user/indexAnon.html.twig', [
                        'user' => $user
            ]);
            
        }
        
    
}
