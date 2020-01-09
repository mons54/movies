<?php

namespace App\Tests;

use App\Entity\Movies;

class MoviesTest extends \Codeception\Test\Unit
{
    /**
     * @var \App\Tests\UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    public function getMovie()
    {
        $this->tester->seeInRepository(Movies::class, [
            'name' => 'Django Unchained'
        ]);
    }

    public function addMovie()
    {
        $movie = new Movies;
        $movie->setName('Deux jours, une nuit');
        $movie->setDate(new \DateTime('2014-10-01'));

        $em = $this->getModule('Doctrine2')->em;
        $em->persist($movie);
        $em->flush();

        $this->assertEquals(
            'Deux jours, une nuit',
            $movie->getName()
        );
        $this->tester->seeInRepository(Movies::class, [
            'name' => 'Deux jours, une nuit'
        ]);
    }
}
