<?php

namespace App\Controller;
use App\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;


class UsersController extends AbstractController
{
    // #[Route('/users', name: 'app_users')]
    // public function index(): Response
    // {
    //     return $this->render('users/index.html.twig', [
    //         'controller_name' => 'UsersController',
    //     ]);
    // }
    #[Route('/users', name: 'dodaj-uzytkownika', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $user = new Users();
        $user->setName($data['name']);
        $user->setSurname($data['surname']);
        $user->setEmail($data['email']);

        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse(['message' => 'User created successfully'], Response::HTTP_CREATED);
    }
    #[Route('/users', name: 'pokaz-uzytkownikow', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $users = $entityManager->getRepository(Users::class)->findAll();

        $formattedUsers = [];
        foreach ($users as $user) {
            $formattedUsers[] = [
                'id' => $user->getId(),
                'name' => $user->getName(),
                'surname' => $user->getSurname(),
                'email' => $user->getEmail(),
            ];
        }

        return new JsonResponse($formattedUsers);
    }

    #[Route('/users/{id}', name: 'pokaz-uzytkownika', methods: ['GET'])]
    public function show($id, EntityManagerInterface $entityManager): Response
    {
        $user = $entityManager->getRepository(Users::class)->find($id);

        $formattedUser = [
            'id' => $user->getId(),
            'name' => $user->getName(),
            'surname' => $user->getSurname(),
            'email' => $user->getEmail(),
        ];

        return new JsonResponse($formattedUser);
    }

    #[Route('/users/{id}', name: 'zaktualizuj-uzytkownika', methods: ['PUT'])]
    public function update($id, Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $existingUser = $entityManager->getRepository(Users::class)->find($id);

        if ($existingUser) {
            $existingUser->setName($data['name']);
            $existingUser->setSurname($data['surname']);
            $existingUser->setEmail($data['email']);
            
            $entityManager->persist($existingUser);
            $entityManager->flush();

            return new JsonResponse(['message' => 'User updated successfully'], Response::HTTP_OK);
        } else {
            return new JsonResponse(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }
    }

    #[Route('/users/{id}', name: 'app_user_delete', methods: ['DELETE'])]
    public function delete($id, EntityManagerInterface $entityManager): JsonResponse
    {
        $user = $entityManager->getRepository(Users::class)->find($id);

        if ($user) {
            $entityManager->remove($user);
            $entityManager->flush();

            return new JsonResponse(['message' => 'User deleted successfully'], Response::HTTP_OK);
        } else {
            return new JsonResponse(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }
    }
}
