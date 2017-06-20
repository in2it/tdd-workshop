<?php

namespace App\Entity;


class Author
{
    /**
     * @var int
     */
    protected $id;
    /**
     * @var string
     */
    protected $firstName;
    /**
     * @var string
     */
    protected $middleName;
    /**
     * @var string
     */
    protected $lastName;
    /**
     * @var string
     */
    protected $bio;

    /**
     * Author constructor.
     * @param int $id
     * @param string $firstName
     * @param string $middleName
     * @param string $lastName
     * @param string $bio
     */
    public function __construct(
        int $id = 0,
        string $firstName = '',
        string $middleName = '',
        string $lastName = '',
        string $bio = ''
    )
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->middleName = $middleName;
        $this->lastName = $lastName;
        $this->bio = $bio;
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
     * @return Author
     */
    public function setId(int $id): Author
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return Author
     */
    public function setFirstName(string $firstName): Author
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return string
     */
    public function getMiddleName(): string
    {
        return $this->middleName;
    }

    /**
     * @param string $middleName
     * @return Author
     */
    public function setMiddleName(string $middleName): Author
    {
        $this->middleName = $middleName;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     * @return Author
     */
    public function setLastName(string $lastName): Author
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return string
     */
    public function getBio(): string
    {
        return $this->bio;
    }

    /**
     * @param string $bio
     * @return Author
     */
    public function setBio(string $bio): Author
    {
        $this->bio = $bio;
        return $this;
    }

}