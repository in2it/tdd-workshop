<?php

namespace App\Service;


class BookService
{
    /**
     * @var \PDO
     */
    protected $pdo;

    /**
     * BookService constructor.
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @return array
     */
    public function getBooks(): array
    {
        $result = $this->pdo->query(
            'SELECT * FROM `book_author` `ba` 
              INNER JOIN `author` `a` ON `ba`.`author_id` = `a`.`id`
              INNER JOIN `book` `b` ON `ba`.`book_id` = `b`.`id`'
        );
        $data = $result->fetchAll(\PDO::FETCH_ASSOC);
        if (false === $data) {
            return [];
        }
        return $data;
    }
}