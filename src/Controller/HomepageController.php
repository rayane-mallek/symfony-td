<?php

namespace App\Controller;

use App\Entity\Concert;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Symfony\Component\HttpFoundation\Request;

#[Route('/', name: 'app_')]
class HomepageController extends AbstractController
{
    #[Route('', name: 'homepage')]
    public function index(PaginatorInterface $paginator, Request $request, ManagerRegistry $doctrine)
    {
        $concertRepository = $doctrine->getRepository(Concert::class);
        $concerts = $concertRepository->findAll();

        $pagination = $paginator->paginate(
            $concerts,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('concerts/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }
}
