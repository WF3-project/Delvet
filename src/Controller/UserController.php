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
            
            $user = $this->getUser();
            dump($user);
            $courses=$coursesRepository->findLastCreatedAt();

            
            if( !empty( $user) )
            {
                
                return $this->render('user/index.html.twig', [
                    'user' => $user,
                    'coursesUser' => $user->getCoursesUser(),
                    'courses'=> $courses
                ]);

            }
            

          
            return $this->render('user/indexAnon.html.twig', [
                        'user' => $user
            ]);
            
        }
<<<<<<< HEAD



       
        
    /**
     * @Route("/user/{id}", name="userCourse")
     */
    
    public function coursesAdd( Courses $course, CoursesRepository $coursesRepository )
    {     
        dump($course);
        $user = $this->getUser();
        dump($user);
        $user->addCoursesUser($course);
        dump($user);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('user');
       
        
        
    }


=======
        
    
>>>>>>> origin/StyleLogin
}
