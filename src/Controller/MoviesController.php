<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Movies;
use App\Form\MoviesSearchType;

class MoviesController extends AbstractController
{
    const LIMIT = 20;

    /**
     * @Route("/", name="index")
     */
    public function index(Request $request)
    {
        $form = $this->createForm(MoviesSearchType::class, new Movies());
        $form->handleRequest($request);

        return $this->render('movies/index.html.twig', [
            'form' => $form->createView(),
            'limit' => self::LIMIT
        ]);
    }

    /**
     * @Route("/movies", name="movies")
     */
    public function movies(Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            return $this->redirect($this->generateUrl('index'));
        }

        $form = $this->createForm(MoviesSearchType::class, new Movies());
        $form->handleRequest($request);

        $data = $form->getData();

        $search = (array) $request->query->get('search', []);
        $orderBy = (string) $request->query->get('orderBy', 'name');
        $asc = (bool) $request->query->get('asc', false);
        $offset = (int) $request->query->get('offset', 0);

        $name = $data->getName();
        $country = $data->getCountry();
        $author = $data->getAuthor();

        $request = $this->getDoctrine()
        ->getRepository(Movies::class)
        ->createQueryBuilder('m')
        ->where('m.name LIKE :name')
        ->setParameter('name', '%' . $name . '%')
        ->orderBy('m.' . $orderBy, $asc ? 'ASC' : 'DESC')
        ->setMaxResults(self::LIMIT)
        ->setFirstResult($offset);

        if ($country) {
            $request->andWhere('m.country LIKE :country');
            $request->setParameter('country', '%' . $country . '%');
        }

        if ($author) {
            $request->andWhere('m.author = :author');
            $request->setParameter('author', $author);
        }

        $movies = $request->getQuery()->execute();

        return $this->render('movies/movies.html.twig', [
            'movies' => $movies,
        ]);
    }
}
