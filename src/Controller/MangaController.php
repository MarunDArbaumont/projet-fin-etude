<?php

// src/Controller/TaskController.php
namespace App\Controller;

use App\Entity\Manga;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\Type\MangaType;
use Doctrine\ORM\EntityManagerInterface;

class MangaController extends AbstractController
{

    

    // Route this controller to the url /manga
    #[Route('/manga', name: 'manga')]
    public function index(): Response
    {
        return $this->render('manga/index.html.twig');
    }


    // Render manga by id
    #[Route('/manga/{id}', name: 'product_show')]
    public function show(EntityManagerInterface $entityManager, int $id): Response
    {
        $manga = $entityManager->getRepository(Manga::class)->find($id);

        if (!$manga) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        return $this->render('main/index.html.twig');

        // or render a template
        // in the template, print things with {{ manga.name }}
        // return $this->render('manga/show.html.twig', ['manga' => $manga]);
    }

    #[Route('/manga/new', name: 'manga_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $manga = new Manga();
        // Fetches the form from the class MangaType
        $form = $this->createForm(MangaType::class, $manga);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            $entityManager->persist($manga);
            $entityManager->flush();

            // Redirect to manga list or a success page
            return $this->redirectToRoute('manga');

            // ... perform some action, such as saving the task to the database

            return $this->redirectToRoute('task_success');
        }
        // Sends the variable new_manga to the template manga/index.html.twig
        return $this->render('manga/new-manga.html.twig', [
            'newManga' => $form->createView(),
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Manga::class,
        ]);
    }
}
