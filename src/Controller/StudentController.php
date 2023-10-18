<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Entity\Student;
use App\Form\StudentType;
use App\Repository\ClassroomRepository;
use App\Repository\StudentRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class StudentController extends AbstractController
{
    #[Route('/student', name: 'app_strudent')]
    public function index(): Response
    {
        return $this->render('student/index.html.twig', [
            'controller_name' => 'StrudentController',
        ]);
    }
    #[Route('/fetch', name: 'fetch')]
    public function fetch(StudentRepository $repo):Response
    {
        $result=$repo->findAll();
        return $this->render('student/test.html.twig',[
            'students'=>$result
        ]);
        

    }
    #[Route('/add', name: 'add')]
    public function add(ManagerRegistry $mr, ClassroomRepository $repo): Response
    {
        $s=new Student();
        $c=$repo->find(1);
        $s->setName('louay');
        $s->setAge(18);
        $s->setEmail('louaynagati@gmail.com');
        $s->setClassroom($c);
        $em=$mr->getManager();
        $em->persist($s);
        $em->flush();
        return new Response('added');
        
    }

    #[Route('/addf', name: 'addf')]
    public function addf(ManagerRegistry $mr, ClassroomRepository $repo, Request $req): Response
    {
        $s=new Student();  // 1-instance
        $form=$this->createForm(StudentType::class,$s);   // 2- creation formulaire
        $form->handleRequest($req);
        if($form->isSubmitted())
        {
            $em=$mr->getManager();
            $em->persist($s);
            $em->flush();
            return $this->redirectToRoute('fetch');
        }
        
        return $this->render('student/add.html.twig', [
            'f'=>$form->createView()
        ]);
        
    }

    

    #[Route('/remove/{id}', name: 'remove')]
    public function remove(StudentRepository $repo,$id,ManagerRegistry $mr): Response
    {
        $student=$repo->find($id);
        $em=$mr->getManager();
        $em->remove($student);
        $em->flush();
        return $this->redirectToRoute('fetch');
    }

    #[Route('/update/{id}', name: 'update' ,methods:['GET','POST'])]
    public function updatee(EntityManagerInterface $em ,ManagerRegistry $doctrine,$id,Request $req,StudentRepository $repo):Response
    {
        $c=$repo->find($id);
        $form=$this->createForm(StudentType::class,$c); //creation de form
        $form->handleRequest($req); 
        if($form->isSubmitted())
        {
        $em=$doctrine->getManager();
        $em->flush();

         
        return $this->redirectToRoute('fetch');
        }
        $formView=$form->createView(); 

        return $this->render('student/add.html.twig',[
        'f'=>$formView
        ]);

    }

}