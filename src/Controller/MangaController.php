<?php

namespace App\Controller;

use App\Entity\Manga;
use App\Form\Type\MangaType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class MangaController extends AbstractController
{
    #[Route('/manga', name: 'manga_list')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $mangas = $entityManager->getRepository(Manga::class)->findAll();

        return $this->render('manga/index.html.twig', [
            'mangas' => $mangas,
        ]);
    }

    #[Route('/manga/{id}', name: 'manga_show', requirements: ['id' => '\d+'])]
    public function show(EntityManagerInterface $entityManager, int $id): Response
    {
        $manga = $entityManager->getRepository(Manga::class)->find($id);

        if (!$manga) {
            throw $this->createNotFoundException('No manga found for id ' . $id);
        }

        return $this->render('manga/show.html.twig', ['manga' => $manga]);
    }

    #[Route('/manga/new', name: 'manga_new')]
    #[IsGranted('ROLE_ADMIN')] // Restrict access to only users with ROLE_ADMIN
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $manga = new Manga();
        $form = $this->createForm(MangaType::class, $manga);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($manga);
            $entityManager->flush();

            $this->addFlash('success', 'Manga successfully added!');

            return $this->redirectToRoute('manga_list');
        }

        return $this->render('manga/new.html.twig', [
            'mangaForm' => $form->createView(),
        ]);
    }
}
