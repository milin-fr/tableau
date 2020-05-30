<?php

namespace App\Controller;

use App\Repository\WorkTeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(WorkTeamRepository $workTeamRepository)
    {
        return $this->render('main/home.html.twig', [
            'teams' => $workTeamRepository->findAll(),
        ]);
    }
}
