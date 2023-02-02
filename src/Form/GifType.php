<?php

namespace App\Form;

use App\Entity\Gif;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class GifType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('gifFile', VichFileType::class, [
                'required' => false,
                'allow_delete' => true,
                'download_uri' => true,
            ]);
        /*
            ->add('gifFile', VichFileType::class, [
                'attr' => [
                    'placeholder' => 'gif.jpg',
                    'maxlength' => 255,
                ],
                'label_attr' => [
                    'class' => 'm-3',
                ],
                'required' => true,
                'label' => 'Gif',
                'required' => false,
                'allow_delete' => true,
                'download_uri' => true,
            ]);*/
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Gif::class,
        ]);
    }
}
