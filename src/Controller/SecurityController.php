<?php
namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\User\UserInterface;


use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;



class SecurityController extends AbstractController
{

    // private $em;

    // public function __construct(EntityManagerInterface $em)
    // {
    //     $this->em = $em;
    // }

    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // $user = $this->getUser();
        // if ($user) {
        //     // If it's the first login, redirect to a specific page
        //     if ($user->getFirstLogin()) {
        //         // Update the first_login field to false
        //         $user->setFirstLogin(false);
        //         $this->em->flush();

        //         // Redirect to first-login page
        //         return $this->redirectToRoute('profile_edit');
        //     }
        //     return $this->redirectToRoute('home');
        // }
        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }
        // Get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // Last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }
    public function logout(): void
    {
        // Symfony will handle the logout automatically, this method can be empty.
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }
    public function firstLogin()
    {
        // Here you can render a page that provides additional steps after first login
        return $this->render('security/first_login.html.twig');
    }
}
