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

    #[Route('/produkt', name: 'dodaj-produkt', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $produkt = new Produkt(); 
        $produkt->setName($data['name']);
        $produkt->setPrice($data['price']);

        $entityManager->persist($produkt);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Product created successfully'], Response::HTTP_CREATED);

    }


    #[Route('/produkt', name: 'pokaz-wszystko', methods: ['GET' ])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $products = $entityManager->getRepository(Produkt::class)->findAll();

        $formattedProducts = [];
        foreach ($products as $product) {
            $formattedProducts[] = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'price' => $product->getPrice()
            ];
        }

        return new JsonResponse($formattedProducts);
    }

    #[Route('/produkt/{id}', name: 'pokaz-produkt', methods: ['GET'])]
    public function show($id, EntityManagerInterface $entityManager): Response
    {
        $product = $entityManager->getRepository(Produkt::class)->find($id);

        if (!$product) {
            return new JsonResponse(['message' => 'Product not found'], Response::HTTP_NOT_FOUND);
        }

        $formattedProduct = [
            'id' => $product->getId(),
            'name' => $product->getName(),
            'price' => $product->getPrice()
            
        ];

        return new JsonResponse($formattedProduct);
    }



    #[Route('/produkt/{id}', name: 'zaktualizuj-produkt', methods: ['PUT'])]
    public function update($id, Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $existingProduct = $entityManager->getRepository(Produkt::class)->find($id);

        if ($existingProduct) {
            $existingProduct->setName($data['name']);
            $existingProduct->setPrice($data['price']);

            $entityManager->flush();

            return new JsonResponse(['message' => 'Product updated successfully'], Response::HTTP_OK);
        } else {
            return new JsonResponse(['message' => 'Product not found'], Response::HTTP_NOT_FOUND);
        }
    }



    #[Route('/produkt/{id}', name: 'usun-produkt', methods: ['DELETE'])]
    public function delete($id, EntityManagerInterface $entityManager): JsonResponse
    {
        $product = $entityManager->getRepository(Produkt::class)->find($id);

        if ($product) {
            $entityManager->remove($product);
            $entityManager->flush();

            return new JsonResponse(['message' => 'Product deleted successfully'], Response::HTTP_OK);
        } else {
            return new JsonResponse(['message' => 'Product not found'], Response::HTTP_NOT_FOUND);
        }
    }
}



