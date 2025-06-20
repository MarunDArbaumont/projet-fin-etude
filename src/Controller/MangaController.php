<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Manga;
use App\Entity\User;
use App\Form\CommentType;
use App\Form\Type\MangaType;
use Doctrine\ORM\EntityManagerInterface;
use Dom\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class MangaController extends AbstractController
{
    public function index(EntityManagerInterface $entityManager): Response
    {
        $mangaList = $entityManager->getRepository(Manga::class)->findAll();
        usort($mangaList, function($a, $b){return strcmp($a->getAuthor(), $b->getAuthor());});

        return $this->render('manga/index.html.twig', [
            'mangas' => $mangaList,
        ]);
    }

    public function show(Manga $manga, Request $request, EntityManagerInterface $em, Security $security): Response
    {
        $comment = new Commentaire();
        $comment->setManga($manga);
        $comment->setCreatedAt(new \DateTime());
        $comment->setAuthor($security->getUser());

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('manga_show', ['id' => $manga->getId()]);
        }
        if ($form->isSubmitted() && !$form->isValid()) {
            dd((string) $form->getErrors(true, false));
        }


        return $this->render('manga/show.html.twig', [
            'manga' => $manga,
            'commentForm' => $form->createView(),
        ]);
    }

    #[IsGranted('ROLE_ADMIN')] // Restrict access to only users with ROLE_ADMIN
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $manga = new Manga();
        $form = $this->createForm(MangaType::class, $manga);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $coverFile */
            $coverFile = $form->get('cover')->getData();
        
            if ($coverFile) {
                $newFilename = uniqid() . '.' . $coverFile->guessExtension();
                $coverFile->move(
                    $this->getParameter('cover_directory'),
                    $newFilename
                );
                $manga->setCover($newFilename); 
            }
        
            $entityManager->persist($manga);
            $entityManager->flush();
        
            return $this->redirectToRoute('manga_list');
        }

        return $this->render('manga/new.html.twig', [
            'mangaForm' => $form->createView(),
        ]);
    }
}
