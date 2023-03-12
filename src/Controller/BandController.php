<?php

namespace App\Controller;

use App\Entity\Band;
use App\Entity\Concert;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/band', name: 'app_band_')]
class BandController extends AbstractController
{
    #[Route('/list', name: 'list', methods: 'GET')]
    public function indexAll(ManagerRegistry $doctrine)
    {
        $bandRepository = $doctrine->getRepository(Band::class);
        $bands = $bandRepository->findAll();

        return $this->render('band/list.html.twig', [
            'bands' => $bands
        ]);
    }

    #[Route('/{id}', name: 'show', methods: 'GET')]
    public function index(ManagerRegistry $doctrine, $id)
    {
        $bandRepository = $doctrine->getRepository(Band::class);
        $band = $bandRepository->find($id);

        $concertRepository = $doctrine->getRepository(Concert::class);
        $concerts = $concertRepository;


        return $this->render('band/band.html.twig', [
            'band' => $band,
            'concerts' => $concerts,
        ]);
    }
}