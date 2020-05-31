<?php

namespace App\Controller;

use App\Entity\WorkTeam;
use App\Repository\ProjectStatusRepository;
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

    /**
     * @Route("/{id<\d+>}", name="team_home")
     */
    public function teamHome(WorkTeam $workTeam, ProjectStatusRepository $projectStatusRepository)
    {
        $projectStatuses = $projectStatusRepository->findAll();
        return $this->render('main/team_home.html.twig', [
            'team' => $workTeam,
            'projectStatuses' => $projectStatuses,
        ]);
    }
}
