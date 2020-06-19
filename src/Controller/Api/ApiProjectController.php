<?php

namespace App\Controller\Api;

use App\Entity\Project;
use App\Entity\Task;
use App\Form\AddProjectType;
use App\Form\ProjectType;
use App\Form\TaskType;
use App\Repository\ProjectRepository;
use App\Repository\ProjectStatusRepository;
use App\Repository\TaskStatusRepository;
use App\Repository\WorkTeamRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
    public function post_project(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, ValidatorInterface $validator, WorkTeamRepository $workTeamRepository, ProjectStatusRepository $projectStatusRepository)
    {
        $json = $request->getContent();
        $contentObject = json_decode($json);
        try {
            $project = $serializer->deserialize($json, Project::class, 'json');
            $project->setWorkTeam($workTeamRepository->find($contentObject->work_team_id));
            $project->setProjectStatus($projectStatusRepository->find($contentObject->project_status_id));
            $errors = $validator->validate($project);
            if(count($errors) > 0) {
                return $this->json($errors, 400);
            }
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
     * @Route("/{id<\d+>}/add-task", name="project_add_task", methods={"PUT"})
     */
    public function project_add_task($id, ProjectRepository $projectRepository, Request $request, SerializerInterface $serializer, EntityManagerInterface $em, TaskStatusRepository $taskStatusRepository)
    {
        $project = $projectRepository->find($id);

        $contentObject = json_decode($request->getContent());
        $taskTitle = $contentObject->task_title;
        $taskStatus = $taskStatusRepository->find(1);

        $task = new Task();
        $task->setTitle($taskTitle);
        $task->setTaskStatus($taskStatus);
        $em->persist($task);
        $project->addTask($task);
        $em->flush();

        return $this->json($project, 200, [], ['groups' => 'get:projects']);

    }

    /**
     * @Route("/{id<\d+>}/project-put-description", name="project_put_description", methods={"PUT"})
     */
    public function project_put_description($id, ProjectRepository $projectRepository, Request $request, SerializerInterface $serializer, EntityManagerInterface $em, TaskStatusRepository $taskStatusRepository)
    {
        $project = $projectRepository->find($id);

        $contentObject = json_decode($request->getContent());
        $projectDescription = $contentObject->project_description;
        $project->setDescription($projectDescription);

        $em->flush();

        return $this->json($project, 200, [], ['groups' => 'get:projects']);

    }

}
