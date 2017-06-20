<?php

namespace App\Test;


use PHPUnit\DbUnit\TestCaseTrait;
use PHPUnit\Framework\TestCase;

class DatabaseTest extends TestCase
{
    use TestCaseTrait;

    protected $pdo = null;

    /**
     * @return PHPUnit_Extensions_Database_DB_IDatabaseConnection
     */
    public function getConnection()
    {
        if (null === $this->pdo) {
            $setupSql = file_get_contents(__DIR__ . '/../data/app.dll.sql');
            $this->pdo = new \PDO('sqlite::memory:');
            $this->pdo->exec($setupSql);
        }
        return $this->createDefaultDBConnection($this->pdo, ':memory:');
    }

    /**
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    public function getDataSet()
    {
        return $this->createFlatXMLDataSet(__DIR__ . '/_files/app-seed.xml');
    }

public function testListingOfBooks()
{
    $this->assertEquals(3, $this->getConnection()->getRowCount('author'), "Reading from author failed");
    $this->assertEquals(2, $this->getConnection()->getRowCount('book'), 'Reading from book failed');
    $this->assertEquals(2, $this->getConnection()->getRowCount('book_author'), 'Reading from book_author failed');
}
}