<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'app_')]
class HomepageController extends AbstractController
{
    #[Route('', name: 'homepage')] 
    public function index() 
    {
        return $this->render('index.html.twig');
    }
}