<?php

namespace App\Controller;

use App\Entity\Band;
use App\Entity\Concert;
use App\Form\BandType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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

    #[Route('/admin/delete/band/{id}', name: 'delete')]
    public function delete(ManagerRegistry $doctrine, Band $band)
    {
        $entityManager = $doctrine->getManager();

        $entityManager->remove($band);
        $entityManager->flush();

        return $this->redirectToRoute('app_band_list');
    }

    #[Route('/admin/create/band', name: 'create')]
    public function create(Request $request, ManagerRegistry $doctrine)
    {
        $band = new Band();

        $form = $this->createForm(BandType::class, $band);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $band = $form->getData();

            $entityManager = $doctrine->getManager();
            $entityManager->persist($band);
            $entityManager->flush();

            return $this->redirectToRoute('app_band_list');
        }

        return $this->render('band/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/update/band/{id}', name: 'update')]
    public function update(Request $request, ManagerRegistry $doctrine, Band $band)
    {
        $bandRepository = $doctrine->getRepository(Band::class);

        $form = $this->createForm(BandType::class, $band);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bandRepository->save($band, true);

            return $this->redirectToRoute('app_band_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('band/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}