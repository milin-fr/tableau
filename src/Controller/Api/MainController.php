<?php

namespace App\Controller\Api;

use App\Repository\WorkTeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/api")
 */
class MainController extends AbstractController
{
    /**
     * @Route("/", name="api_home")
     */
    public function home(WorkTeamRepository $workTeamRepository)
    {
        $workTeams = $workTeamRepository->findAll();
        return $this->json($workTeams, Response::HTTP_OK, [], []);
    }
}
