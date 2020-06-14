<?php

namespace App\Controller;

use App\Entity\WorkTeam;
use App\Form\WorkTeamType;
use App\Repository\WorkTeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/work-team")
 */
class WorkTeamController extends AbstractController
{
    /**
     * @Route("/", name="work_team_index", methods={"GET"})
     */
    public function index(WorkTeamRepository $workTeamRepository): Response
    {
        return $this->render('work_team/index.html.twig', [
            'work_teams' => $workTeamRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="work_team_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $workTeam = new WorkTeam();
        $form = $this->createForm(WorkTeamType::class, $workTeam);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($workTeam);
            $entityManager->flush();

            return $this->redirectToRoute('work_team_index');
        }

        return $this->render('work_team/new.html.twig', [
            'work_team' => $workTeam,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="work_team_show", methods={"GET"})
     */
    public function show(WorkTeam $workTeam): Response
    {
        return $this->render('work_team/show.html.twig', [
            'work_team' => $workTeam,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="work_team_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, WorkTeam $workTeam): Response
    {
        $form = $this->createForm(WorkTeamType::class, $workTeam);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('work_team_index');
        }

        return $this->render('work_team/edit.html.twig', [
            'work_team' => $workTeam,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="work_team_delete", methods={"DELETE"})
     */
    public function delete(Request $request, WorkTeam $workTeam): Response
    {
        if ($this->isCsrfTokenValid('delete'.$workTeam->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($workTeam);
            $entityManager->flush();
        }

        return $this->redirectToRoute('work_team_index');
    }
}
