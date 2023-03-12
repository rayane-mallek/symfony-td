<?php

namespace App\Controller;

use App\Entity\Concert;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'app_')]
class HomepageController extends AbstractController
{
    #[Route('', name: 'homepage')]
    public function index(ManagerRegistry $doctrine)
    {
        $concertRepository = $doctrine->getRepository(Concert::class);
        $concerts = $concertRepository->findAll();

        return $this->render('index.html.twig', [
            'concerts' => $concerts
        ]);
    }
}