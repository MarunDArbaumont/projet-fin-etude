<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserProfileType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Entity\Manga;

class ProfileController extends AbstractController
{

    public function index(Request $request, EntityManagerInterface $em)
    {
        $user = $this->getUser();
        if(!$user){
            return $this->redirectToRoute('app_login');
        }


        return $this->render('profile/index.html.twig', [
            'user' => $user,
        ]);
    }

    public function show(EntityManagerInterface $entityManager, int $id):Response
    {
        $user = $entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            throw $this->createNotFoundException('No user found for id ' . $id);
        }

        return $this->render('profile/show.html.twig', ['user' => $user]);
    }

    public function edit(Request $request, EntityManagerInterface $em)
    {
        $user = $this->getUser();

        $form = $this->createForm(UserProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Profile updated successfully!');
            return $this->redirectToRoute('profile');
        }

        return $this->render('profile/edit.html.twig', [
            'profileForm' => $form->createView(),
        ]);
    }

    public function add(int $id,EntityManagerInterface $entityManager): RedirectResponse
    {

        $user = $this->getUser();

        if (!$user) {
            throw new AccessDeniedException();
        }

        $manga = $entityManager->getRepository(Manga::class)->find($id);

        if (!$manga) {
            throw $this->createNotFoundException('Manga not found.');
        }

        $user->addManga($manga);
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('manga_list');
    }
}
