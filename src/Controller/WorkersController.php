<?php

namespace App\Controller;
use App\Entity\Workers;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class WorkersController extends AbstractController
{
    // #[Route('/workers', name: 'app_workers')]
    // public function index(): Response
    // {
    //     return $this->render('workers/index.html.twig', [
    //         'controller_name' => 'WorkersController',
    //     ]);
    // }

    #[Route('/workers', name: 'dodaj-pracownika', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $worker = new Workers();
        $worker->setType($data['type']);
        $worker->setSalary($data['salary']);

        $entityManager->persist($worker);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Worker created successfully'], Response::HTTP_CREATED);
    }
    #[Route('/workers', name: 'pokaz-pracownikow', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $workers = $entityManager->getRepository(Workers::class)->findAll();

        $formattedWorkers = [];
        foreach ($workers as $worker) {
            $formattedWorkers[] = [
                'id' => $worker->getId(),
                'type' => $worker->getType(),
                'salary' => $worker->getSalary(),
            ];
        }

        return new JsonResponse($formattedWorkers);
    }

    #[Route('/workers/{id}', name: 'pokaz-pracownika', methods: ['GET'])]
    public function show($id, EntityManagerInterface $entityManager): Response
    {
        $worker = $entityManager->getRepository(Workers::class)->find($id);

        $formattedWorker[] = [
            'id' => $worker->getId(),
            'type' => $worker->getType(),
            'salary' => $worker->getSalary(),
        ];

        return new JsonResponse($formattedWorker);
    }

    #[Route('/workers/{id}', name: 'zaktualizuj-pracownika', methods: ['PUT'])]
    public function update($id, Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $existingWorker = $entityManager->getRepository(Workers::class)->find($id);

        if ($existingWorker) {
            $existingWorker->setType($data['type']);
            $existingWorker->setSalary($data['salary']);
            
            $entityManager->persist($existingWorker);
            $entityManager->flush();

            return new JsonResponse(['message' => 'Worker updated successfully'], Response::HTTP_OK);
        } else {
            return new JsonResponse(['message' => 'Worker not found'], Response::HTTP_NOT_FOUND);
        }
    }

    #[Route('/workers/{id}', name: 'usun-pracownika', methods: ['DELETE'])]
    public function delete($id, EntityManagerInterface $entityManager): JsonResponse
    {
        $worker = $entityManager->getRepository(Workers::class)->find($id);

        if ($worker) {
            $entityManager->remove($worker);
            $entityManager->flush();

            return new JsonResponse(['message' => 'Worker deleted successfully'], Response::HTTP_OK);
        } else {
            return new JsonResponse(['message' => 'Worker not found'], Response::HTTP_NOT_FOUND);
        }
    }
}
