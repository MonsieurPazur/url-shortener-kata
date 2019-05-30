<?php

/**
 * Test suite for storing and retrieving urls from in-memory database.
 */

namespace Test;

use App\UrlDatabase;
use Generator;
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
     *
     * @dataProvider visitsProvider
     *
     * @param string $hash shortened hash
     * @param string $url long url
     * @param int $expected number of visits
     */
    public function testGetVisits(string $hash, string $url, int $expected): void
    {
        $this->database->insert($hash, $url);

        for ($i = 0; $i < $expected; $i++) {
            $this->database->retrieveUrl($hash);
        }
        $visits = $this->database->getVisits($hash);
        $this->assertEquals($expected, $visits);
    }

    /**
     * Provides data with different times of url visits.
     *
     * @return Generator
     */
    public function visitsProvider(): Generator
    {
        yield 'not visited at all' => [
            'hash' => 'otu5ngy1',
            'url' => 'https://some-long-url.com/something',
            'expected' => 0
        ];
        yield 'visited 17 times' => [
            'hash' => 'otu5ngy1',
            'url' => 'https://some-long-url.com/something',
            'expected' => 17
        ];
    }
}
