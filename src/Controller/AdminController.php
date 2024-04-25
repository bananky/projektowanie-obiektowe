<?php

namespace App\Controller;
use App\Entity\Produkt;
use App\Entity\Users;
use App\Entity\Workers;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\Event\WorkerStartedEvent;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\ORM\EntityManagerInterface;

class AdminController extends AbstractController
{
    // #[Route('/admin', name: 'app_admin')]
    // public function index(): Response
    // {
    //     return $this->render('admin/index.html.twig', [
    //         'controller_name' => 'AdminController',
    //     ]);
    // }

    #[Route('/login', name: 'admin_login', methods: ['GET','POST'])]
    public function login(Request $request, SessionInterface $session): Response
    {
        // Przyjęcie danych logowania z formularza
        $username = $request->request->get('username');
        $password = $request->request->get('password');

        // Walidacja danych logowania - to tylko przykład, zaleca się użycie
        // mechanizmu uwierzytelniania Symfony, takiego jak Guard Authentication
        if ($username === 'admin' && $password === 'admin123') {
            // Ustawienie flagi admin w sesji
            $session->set('admin', true);

            // Przekierowanie na stronę panelu administracyjnego
            return $this->redirectToRoute('admin_panel');
        }

        // Jeśli dane logowania są nieprawidłowe, możemy przekierować z powrotem na stronę logowania
        return $this->render('admin/login.html.twig');
    }

    #[Route('/panel-administracyjny', name: 'admin_panel')]
    public function adminPanel(SessionInterface $session): Response
    {
        // Sprawdzenie czy użytkownik jest zalogowany jako administrator
        if (!$session->get('admin')) {
            // Przekierowanie na stronę logowania, jeśli nie jest zalogowany
            return $this->redirectToRoute('admin_login_page');
        }

        // Renderowanie widoku panelu administracyjnego
        return $this->render('admin/dashboard.html.twig');
    }


}
