<?php

namespace App\Controller;

use App\Entity\Produkt;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;

class ProduktController extends AbstractController
{
    // #[Route('/produkt', name: 'app_produkt')]
    // public function index(): Response
    // {
    //     return $this->render('produkt/index.html.twig', [
    //         'controller_name' => 'ProduktController',
    //     ]);
    // }

    #[Route('/dodaj-produkt', name: 'dodaj-produkt', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($request->isMethod('POST')) {
            $data = $request->request->all();

            $produkt = new Produkt();
            $produkt->setName($data['name']);
            $produkt->setPrice($data['price']);

            $entityManager->persist($produkt);
            $entityManager->flush();

            $this->addFlash('success', 'Product created successfully');

            return $this->redirectToRoute('pokaz-wszystko');
        }

        return $this->render('produkt/create.html.twig');
    }


    #[Route('/produkt', name: 'pokaz-wszystko', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $products = $entityManager->getRepository(Produkt::class)->findAll();

        return $this->render('produkt/index.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/produkt/{id}', name: 'pokaz-produkt', methods: ['GET'])]
    public function show($id, EntityManagerInterface $entityManager): Response
    {
        $product = $entityManager->getRepository(Produkt::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException('Product not found');
        }

        return $this->render('produkt/show.html.twig', [
            'product' => $product,
        ]);
    }



    #[Route('/zaktualizuj-produkt/{id}', name: 'zaktualizuj-produkt', methods: ['GET','PUT'])]
    public function update($id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $product = $entityManager->getRepository(Produkt::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException('Product not found');
        }

        if ($request->isMethod('PUT')) {
            $data = $request->request->all();

            $product->setName($data['name']);
            $product->setPrice($data['price']);

            $entityManager->flush();

            $this->addFlash('success', 'Product updated successfully');

            return $this->redirectToRoute('pokaz-produkt', ['id' => $product->getId()]);
        }

        return $this->render('produkt/update.html.twig', [
            'product' => $product,
        ]);
    }



    #[Route('/usun-produkt/{id}', name: 'usun-produkt', methods: ['GET','POST','DELETE'])]
    public function delete($id, EntityManagerInterface $entityManager): Response
    {
        $product = $entityManager->getRepository(Produkt::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException('Product not found');
        }

        $entityManager->remove($product);
        $entityManager->flush();

        $this->addFlash('success', 'Product deleted successfully');

        return $this->redirectToRoute('pokaz-wszystko');
    }
}



