<?php

namespace App\Form\Type;

use App\Entity\Manga;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MangaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['required' => true])
            ->add('description', TextType::class, ['required' => true])
            ->add('author', TextType::class, ['required' => true])
            ->add('cover', FileType::class, ['required' => false])
            ->add('releaseDate', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
            ])
            ->add('save', SubmitType::class, ['label' => 'Add Manga']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Manga::class,
            'csrf_protection' => true, // CSRF security
        ]);
    }
}
