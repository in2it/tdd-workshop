<?php

namespace App\Entity;


class Book
{
    /**
     * @var int
     */
    protected $id;
    /**
     * @var string
     */
    protected $title;
    /**
     * @var string
     */
    protected $summary;
    /**
     * @var string
     */
    protected $isbn;
    /**
     * @var Author[]
     */
    protected $authors;

    /**
     * Book constructor.
     * @param int $id
     * @param string $title
     * @param string $summary
     * @param string $isbn
     */
    public function __construct(int $id = 0, string $title = '', string $summary = '', string $isbn = '')
    {
        $this->id = $id;
        $this->title = $title;
        $this->summary = $summary;
        $this->isbn = $isbn;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Book
     */
    public function setId(int $id): Book
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Book
     */
    public function setTitle(string $title): Book
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getSummary(): string
    {
        return $this->summary;
    }

    /**
     * @param string $summary
     * @return Book
     */
    public function setSummary(string $summary): Book
    {
        $this->summary = $summary;
        return $this;
    }

    /**
     * @return string
     */
    public function getIsbn(): string
    {
        return $this->isbn;
    }

    /**
     * @param string $isbn
     * @return Book
     */
    public function setIsbn(string $isbn): Book
    {
        $this->isbn = $isbn;
        return $this;
    }

    /**
     * @return Author[]
     */
    public function getAuthors(): array
    {
        return $this->authors;
    }

    /**
     * @param Author[] $authors
     * @return Book
     */
    public function setAuthors(array $authors): Book
    {
        $this->authors = $authors;
        return $this;
    }

    /**
     * @param Author $author
     * @return Book
     */
    public function addAuthor(Author $author): book
    {
        $this->authors[] = $author;
        return $this;
    }
}