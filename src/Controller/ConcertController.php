<?php

namespace App\Controller;

use App\Entity\Concert;
use App\Form\ConcertType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/concert', name: 'app_concert_')]
class ConcertController extends AbstractController
{

    #[Route('/list', name: 'list')]
    public function indexAll(ManagerRegistry $doctrine)
    {
        $concertRepository = $doctrine->getRepository(Concert::class);
        $concerts = $concertRepository->findFutureConcerts();

        return $this->render('concert/list.html.twig', [
            'concerts' => $concerts
        ]);
    }

    #[Route('/concert/{id}', name: 'concert')]
    public function show(ManagerRegistry $doctrine, $id)
    {
        $concertRepository = $doctrine->getRepository(Concert::class);
        $concert = $concertRepository->find($id);

        if (!$concert) {
            throw $this->createNotFoundException('Concert not found');
        }

        return $this->render('concert/concert.html.twig', [
            'concert' => $concert
        ]);
    }

    #[Route('/admin/create', name: 'create')]
    public function index(Request $request, ManagerRegistry $doctrine)
    {
        $show = new Concert();

        $form = $this->createForm(ConcertType::class, $show);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $show = $form->getData();

            $entityManager = $doctrine->getManager();
            $entityManager->persist($show);
            $entityManager->flush();

            return $this->redirectToRoute('app_concert_list');
        }

        return $this->render('concert/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/archive', name: 'archive', methods: 'GET')]
    public function indexAllArchive(ManagerRegistry $doctrine)
    {
        $concertRepository = $doctrine->getRepository(Concert::class);
        $concerts = $concertRepository->findArchived();

        return $this->render('concert/archive.html.twig', [
           'concerts' => $concerts
       ]);
    }

    #[Route('/admin/delete/{id}', name: 'delete')]
    public function delete(ManagerRegistry $doctrine, Concert $concert)
    {
        $entityManager = $doctrine->getManager();

        $entityManager->remove($concert);
        $entityManager->flush();

        return $this->redirectToRoute('app_concert_list');
    }

    #[Route('/admin/update/{id}', name: 'update')]
    public function update(Request $request, ManagerRegistry $doctrine, Concert $concert)
    {
        $concertRepository = $doctrine->getRepository(Concert::class);

        $form = $this->createForm(ConcertType::class, $concert);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $concertRepository->save($concert, true);

            return $this->redirectToRoute('app_concert_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('concert/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}