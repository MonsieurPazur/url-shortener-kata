<?php

/**
 * Test suite for storing and retrieving urls from in-memory database.
 */

namespace Test;

use App\UrlDatabase;
use PHPUnit\Framework\TestCase;

/**
 * Class UrlDatabaseTest
 *
 * @package Test
 */
class UrlDatabaseTest extends TestCase
{
    /**
     * @var UrlDatabase $database class we test
     */
    private $database;

    /**
     * Sets up url database.
     */
    protected function setUp(): void
    {
        $this->database = new UrlDatabase();
    }

    /**
     * Tests getting url from database.
     */
    public function testGetUrl(): void
    {
        $url = $this->database->getUrl('non-existing-url');
        $this->assertEquals('', $url);
    }

    /**
     * Tests inserting data into database.
     */
    public function testInsert(): void
    {
        $this->database->insert('otu5ngy1', 'https://some-long-url.com/something');
        $url = $this->database->getUrl('otu5ngy1');
        $this->assertEquals('https://some-long-url.com/something', $url);
    }

    /**
     * Tests getting visits from database.
     */
    public function testGetVisits(): void
    {
        $this->database->insert('otu5ngy1', 'https://some-long-url.com/something');

        $this->database->getUrl('otu5ngy1');
        $this->database->getUrl('otu5ngy1');
        $this->database->getUrl('otu5ngy1');

        $visits = $this->database->getVisits('otu5ngy1');
        $this->assertEquals(3, $visits);
    }
}
