<?php

namespace App\Controller\Api;

use App\Entity\Project;
use App\Form\AddProjectType;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("api/project")
 */
class ApiProjectController extends AbstractController
{
    /**
     * @Route("/", name="get_projects", methods={"GET"})
     */
    public function get_projects(ProjectRepository $projectRepository): Response
    {
        return $this->json($projectRepository->findAll(), 200, [], ['groups' => 'get:projects']);
    }

    /**
     * @Route("/{id<\d+>}", name="get_project", methods={"GET"})
     */
    public function get_project($id, ProjectRepository $projectRepository): Response
    {
        return $this->json($projectRepository->find($id), 200, [], ['groups' => 'get:projects']);
    }

    /**
     * @Route("/", name="post_project", methods={"POST"})
     */
    public function post_project(Request $request, SerializerInterface $serializer, EntityManagerInterface $em)
    {
        $json = $request->getContent();
        try {
            $project = $serializer->deserialize($json, Project::class, 'json');
            $em->persist($project);
            $em->flush();

            return $this->json($project, 201, [], ['groups' => 'get:projects']);
        } catch(NotEncodableValueException $e) {
            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()
            ], 400);
        }

    }

    /**
     * @Route("/{id<\d+>}", name="project_show", methods={"GET"})
     */
    public function show(Project $project): Response
    {
        return $this->render('project/show.html.twig', [
            'project' => $project,
        ]);
    }

    /**
     * @Route("/{id<\d+>}/edit", name="project_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Project $project): Response
    {
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('project_index');
        }

        return $this->render('project/edit.html.twig', [
            'project' => $project,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id<\d+>}", name="project_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Project $project): Response
    {
        if ($this->isCsrfTokenValid('delete'.$project->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($project);
            $entityManager->flush();
        }

        return $this->redirectToRoute('project_index');
    }

    /**
     * @Route("/add", name="project_add", methods={"GET","POST"})
     */
    public function add(Request $request): Response
    {
        $project = new Project();
        $form = $this->createForm(AddProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($project);
            $entityManager->flush();

            return $this->redirectToRoute('project_index');
        }

        return $this->render('project/new.html.twig', [
            'project' => $project,
            'form' => $form->createView(),
        ]);
    }

}
