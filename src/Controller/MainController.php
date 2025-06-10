<?php

namespace App\Controller;

use App\Entity\Manga;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class MainController extends AbstractController
{
    public function index(EntityManagerInterface $entityManager): Response
    {
        $mangaList = $entityManager->getRepository(Manga::class)->findAll();
        shuffle($mangaList);
        array_splice($mangaList, 4, count($mangaList));

        return $this->render('main/index.html.twig', [
            'mangas' => $mangaList,
        ]);
    }

    public function mentions(): Response
    {
        return $this->render('main/mentions.html.twig');
    }
}
