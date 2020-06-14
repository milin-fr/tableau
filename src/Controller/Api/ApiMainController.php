<?php

namespace App\Controller\Api;

use App\Repository\WorkTeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api")
 */
class ApiMainController extends AbstractController
{
    /**
     * @Route("/", name="api_home")
     */
    public function home(WorkTeamRepository $workTeamRepository, SerializerInterface $serializer)
    {
        $workTeams = $workTeamRepository->findAll();

        $json = $serializer->serialize($workTeams, 'json', []);

        return new Response($json, 200, [
            "Content-Type" => "application/json"
        ]);
    }
}
