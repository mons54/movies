<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Form\MoviesType;
use App\Entity\Movies;

/**
 * @Route("/movies", name="admin_movies_")
 */
class MoviesController extends AbstractController
{
    /**
     * @Route("/", name="add")
     */
    public function add(Request $request)
    {
        $movie = new Movies;
        $form = $this->createForm(MoviesType::class, $movie)
        ->add('save', SubmitType::class, [
            'label' => "Ajouter"
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $movie = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($movie);
            $entityManager->flush();
            return $this->redirectToRoute('admin_movies_edit', [
                'id' => $movie->getId()
            ]);
        }

        return $this->render('admin/movies/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="edit")
     */
    public function edit($id, Request $request)
    {
        $movie = $this->getDoctrine()
        ->getRepository(Movies::class)
        ->find($id);

        $form = $this->createForm(MoviesType::class, $movie)
        ->add('save', SubmitType::class, [
            'label' => "Modifier"
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $movie = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($movie);
            $entityManager->flush();
        }

        return $this->render('admin/movies/edit.html.twig', [
            'form' => $form->createView(),
            'movie' => $movie,
        ]);
    }
}
