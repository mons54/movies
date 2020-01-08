<?php

namespace App\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Entity\Authors;
use App\Entity\Movies;

class MoviesSearchType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Movies::class,
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => "Nom du film",
                    'class' => 'mr-sm-2',
                ],
            ])
            ->add('country', TextType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => "Pays",
                    'class' => 'mr-sm-2',
                ],
            ])
            ->add('author', EntityType::class, [
                'class' => Authors::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('a')
                        ->orderBy('a.name', 'ASC');
                },
                'required' => false,
                'placeholder' => "Auteur",
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'mr-sm-2',
                ],
            ])
            ->add('search', SubmitType::class, [
                'label' => 'Rechercher',
            ])
            ->setMethod('GET')
        ;
    }

    public function getBlockPrefix()
    {
        return 'search';
    }
}
