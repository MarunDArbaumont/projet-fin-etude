<?php

namespace App\Controller;

use App\Entity\Manga;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MangaController extends AbstractController
{
    public function new(Request $request): Response
    {
        // creates a task object and initializes some data for this example
        $manga = new Manga();
        // $manga->setTask('Write a blog post');
        // $manga->setDueDate(new \DateTimeImmutable('tomorrow'));

        $form = $this->createFormBuilder($manga)
            ->add('name', TextType::class)
            ->add('description', TextType::class)
            ->add('author', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Create Manga'])
            ->getForm();
    }
}
