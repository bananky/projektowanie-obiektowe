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
    #[Route('/dodaj-uzytkownika', name: 'dodaj-uzytkownika', methods: ['GET','POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($request->isMethod('POST')) {
            $data = $request->request->all();

            $user = new Users();
            $user->setName($data['name']);
            $user->setSurname($data['surname']);
            $user->setEmail($data['email']);
    
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'User created successfully');

            return $this->redirectToRoute('pokaz-uzytkownikow');
        }

        return $this->render('users/create.html.twig');
    }

    #[Route('/users', name: 'pokaz-uzytkownikow', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $users = $entityManager->getRepository(Users::class)->findAll();

        return $this->render('users/index.html.twig', [
            'users' => $users,
        ]);
    }


    #[Route('/pokaz-uzytkownika/{id}', name: 'pokaz-uzytkownika', methods: ['GET'])]
    public function show($id, EntityManagerInterface $entityManager): Response
    {
        $user = $entityManager->getRepository(Users::class)->find($id);

        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        return $this->render('users/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/zaktualizuj-uzytkownika/{id}', name: 'zaktualizuj-uzytkownika', methods: ['GET','PUT'])]
    public function update($id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $entityManager->getRepository(Users::class)->find($id);

        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        if ($request->isMethod('PUT')) {
            $data = $request->request->all();

            $user->setName($data['name']);
            $user->setSurname($data['surname']);
            $user->setEmail($data['email']);

            $entityManager->flush();

            $this->addFlash('success', 'User updated successfully');

            return $this->redirectToRoute('pokaz-uzytkownika', ['id' => $user->getId()]);
        }

        return $this->render('users/update.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/usun-uzytkownika/{id}', name: 'usun-uzytkownika', methods: ['GET','POST','DELETE'])]
    public function delete($id, EntityManagerInterface $entityManager): Response
    {
        $user = $entityManager->getRepository(Users::class)->find($id);

        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        $entityManager->remove($user);
        $entityManager->flush();

        $this->addFlash('success', 'User deleted successfully');

        return $this->redirectToRoute('pokaz-uzytkownikow');
    }

}
