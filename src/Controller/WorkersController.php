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

    #[Route('/dodaj-pracownika', name: 'dodaj-pracownika', methods: ['GET','POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($request->isMethod('POST')) {
            $data = $request->request->all();

            $worker = new Workers();
            $worker->setType($data['type']);
            $worker->setSalary($data['salary']);

            $entityManager->persist($worker);
            $entityManager->flush();
            $this->addFlash('success', 'Worker created successfully');

            return $this->redirectToRoute('pokaz-pracownikow');
        }

        return $this->render('workers/create.html.twig');
    }

    
    #[Route('/workers', name: 'pokaz-pracownikow', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $workers = $entityManager->getRepository(Workers::class)->findAll();

        return $this->render('workers/index.html.twig', [
            'workers' => $workers,
        ]);
    }


    #[Route('/pokaz-pracownika/{id}', name: 'pokaz-pracownika', methods: ['GET'])]
    public function show($id, EntityManagerInterface $entityManager): Response
    {
        $worker = $entityManager->getRepository(Workers::class)->find($id);

        if (!$worker) {
            throw $this->createNotFoundException('Worker not found');
        }

        return $this->render('workers/show.html.twig', [
            'worker' => $worker,
        ]);
    }



    #[Route('/zaktualizuj-pracownika/{id}', name: 'zaktualizuj-pracownika', methods: ['GET','PUT'])]
    public function update($id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $worker = $entityManager->getRepository(Workers::class)->find($id);

        if (!$worker) {
            throw $this->createNotFoundException('Worker not found');
        }

        if ($request->isMethod('PUT')) {
            $data = $request->request->all();

            $worker->setType($data['type']);
            $worker->setSalary($data['salary']);

            $entityManager->flush();

            $this->addFlash('success', 'Worker updated successfully');

            return $this->redirectToRoute('pokaz-pracownika', ['id' => $worker->getId()]);
        }

        return $this->render('workers/update.html.twig', [
            'worker' => $worker,
        ]);
    }

    #[Route('/usun-pracownika/{id}', name: 'usun-pracownika', methods: ['GET','PUT','DELETE'])]
    public function delete($id, EntityManagerInterface $entityManager): Response
    {
        $worker = $entityManager->getRepository(Workers::class)->find($id);

        if (!$worker) {
            throw $this->createNotFoundException('Worker not found');
        }

        $entityManager->remove($worker);
        $entityManager->flush();

        $this->addFlash('success', 'Worker deleted successfully');

        return $this->redirectToRoute('pokaz-pracownikow');
    }


}
