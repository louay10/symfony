<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServiceController extends AbstractController
{
    #[Route('/show/{name}', name: 'show')]
    public function showService($name):Response{
        return new Response("afficher service:".$name);
     }


     #[Route('/index', name: 'index')]
    public function goToIndex():RedirectResponse{
        return $this->redirectToRoute('home');
     }


     
}
