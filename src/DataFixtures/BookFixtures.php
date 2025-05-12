<?php

namespace App\DataFixtures;

use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BookFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        foreach ([['title' => '1984', 'author' => 'George Orwell', 'year' => 1949, 'isbn' => '97804515935'], ['title' => 'Brave New World', 'author' => 'Aldous Huxley', 'year' => 1932, 'isbn' => '0060850524'],] as $data) {
            $book = new Book();
            $book->setTitle($data['title']);
            $book->setAuthor($data['author']);
            $book->setYear($data['year']);
            $book->setIsbn($data['isbn']);
            $manager->persist($book);
        }

        $manager->flush();
    }
}
