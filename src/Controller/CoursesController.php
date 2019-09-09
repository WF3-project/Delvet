<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Entity\Courses;
use App\Form\CoursesType;
use App\Repository\CategoriesRepository;
use App\Repository\CoursesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/courses")
 */
class CoursesController extends AbstractController
{
    /**
     * @Route("/indexcourses", name="indexcourses")
     */
    public function index(CoursesRepository $coursesRepository): Response
    {
        return $this->render('courses/index.html.twig', [
            'courses' => $coursesRepository->findAll(),
        ]);
    }
     /**
     * @Route("/list/{page}", name="courses")
     */
    public function listCourses($page=1 , CoursesRepository $coursesRepository, CategoriesRepository $categoriesRepository
    ): Response
    {
        $max_pages = ceil($coursesRepository->count([]) / 25);
        $courses = $coursesRepository->findAllWithPagination($page);

        return $this->render('courses/listCourses.html.twig', [
            'courses' => $courses,
            'categories' => $categoriesRepository->findAll(),
            'max_pages' => $max_pages,
            'current_page' => $page,

        ]);
    } 
    
    /**
    * @Route("/course/{id}", name="course")
    */
   public function Course(Courses $id , CoursesRepository $coursesRepository
   ): Response
   {
       dump($id);
       dump($coursesRepository->findById($id));
       return $this->render('courses/Course.html.twig', [
           'course' => $id,
           

       ]);
   }

    /**
     * @Route("/new", name="courses_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $course = new Courses();
        $form = $this->createForm(CoursesType::class, $course);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($course);
            $entityManager->flush();

            return $this->redirectToRoute('courses');
        }

        return $this->render('courses/new.html.twig', [
            'course' => $course,
            'form' => $form->createView(),
        ]);
    }

   
     

     /**
     * @Route("/category/{slug}/{page}", name="categorieCour")
     */
    public function categorieCour($page=1, Categories $categorie,CoursesRepository $coursesRepository, CategoriesRepository $categoriesRepository)
    {
        
        $max_pages = ceil(count($coursesRepository->findAllByCategoriesId($categorie->getId()))/25);
        
        return $this->render('courses/categorie.html.twig', [
            'courses' => $coursesRepository->findAllByCategoriesId($categorie->getId()),           
            'categorie' => $categorie,
            'max_pages' => $max_pages,
            'current_page' => $page,
            
        ]);
    }
    /**
     * @Route("/categoriepage/{page}", name="categorieCourpage")
     */
    public function categorieCourpage($page=1, Categories $categorie,CoursesRepository $coursesRepository, CategoriesRepository $categoriesRepository)
    {
        
        $max_pages = ceil(count($coursesRepository->findAllByCategoriesId($categorie->getId()))/25);
        
        return $this->render('courses/categorie.html.twig', [
            'courses' => $coursesRepository->findAllByCategoriesId($categorie->getId()),           
            'categorie' => $categorie,
            'max_pages' => $max_pages,
            'current_page' => $page,
            
        ]);
    }

    /**
     * @Route("/{id}", name="courses_show", methods={"GET"})
     */
    public function show(Courses $course): Response
    {
        return $this->render('courses/show.html.twig', [
            'course' => $course,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="courses_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Courses $course): Response
    {
        $form = $this->createForm(CoursesType::class, $course);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('courses');
        }

        return $this->render('courses/edit.html.twig', [
            'course' => $course,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="courses_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Courses $course): Response
    {
        if ($this->isCsrfTokenValid('delete'.$course->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($course);
            $entityManager->flush();
        }

        return $this->redirectToRoute('courses');
    }




}
