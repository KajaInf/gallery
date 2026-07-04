<?php

/**
 * Photo form type.
 */

namespace App\Form;

use App\Entity\Gallery;
use App\Entity\Photo;
use App\Entity\Tag;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

/**
 * Class PhotoType.
 */
class PhotoType extends AbstractType
{
    /**
     * Builds photo form.
     *
     * @param FormBuilderInterface $builder Form builder
     * @param array                $options Form options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('imageFile', FileType::class, [
                'label' => 'Zdjęcie',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                new Image([
                    'mimeTypes' => [
                    'image/jpeg',
                    'image/png',
                    'image/webp',
                    ],
                    'mimeTypesMessage' => 'Proszę przesłać poprawny plik graficzny.',
                ]),
                ],
            ])
            ->add('gallery', EntityType::class, [
                'class' => Gallery::class,
                'choice_label' => 'title',
            ])
            ->add('tags', EntityType::class, [
                'class' => Tag::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
            ]);
    }

    /**
     * Configures photo form options.
     *
     * @param OptionsResolver $resolver Options resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Photo::class,
        ]);
    }
}
