<?php

/**
 * Test suite for shortening urls functionalities.
 */

namespace Test;

use App\UrlShortener;
use PHPUnit\Framework\TestCase;

/**
 * Class UrlShortenerTest
 *
 * @package Test
 */
class UrlShortenerTest extends TestCase
{
    /**
     * @var UrlShortener $shortener object that we test
     */
    private $shortener;

    /**
     * Sets up shortener.
     */
    protected function setUp(): void
    {
        $this->shortener = new UrlShortener();
    }

    /**
     * Tests shortening urls.
     */
    public function testShorteningUrl(): void
    {
        $shortUrl = $this->shortener->translate('https://some-long-url.com/something');
        $this->assertEquals('https://short.url/otu5ngy1', $shortUrl);
    }

    /**
     * Tests retrieving long urls from hashed short ones.
     */
    public function testRetrievingUlr(): void
    {
        $this->shortener->translate('https://some-long-url.com/something');
        $longUrl = $this->shortener->retrieve('https://short.url/otu5ngy1');
        $this->assertEquals('https://some-long-url.com/something', $longUrl);
    }

    /**
     * Tests getting stats about given url.
     */
    public function testStatistics(): void
    {
        $this->shortener->translate('https://some-long-url.com/something');

        $this->shortener->retrieve('https://short.url/otu5ngy1');
        $this->shortener->retrieve('https://short.url/otu5ngy1');
        $this->shortener->retrieve('https://short.url/otu5ngy1');
        $this->shortener->retrieve('https://short.url/otu5ngy1');
        $this->shortener->retrieve('https://short.url/otu5ngy1');
        $this->shortener->retrieve('https://short.url/otu5ngy1');

        $stats = $this->shortener->getStats('https://some-long-url.com/something');
        $this->assertEquals('https://short.url/otu5ngy1 | https://some-long-url.com/something | 6', $stats);

        $this->shortener->retrieve('https://short.url/otu5ngy1');
        $this->shortener->retrieve('https://short.url/otu5ngy1');
        $this->shortener->retrieve('https://short.url/otu5ngy1');

        $stats = $this->shortener->getStats('https://short.url/otu5ngy1');
        $this->assertEquals('https://short.url/otu5ngy1 | https://some-long-url.com/something | 9', $stats);
    }
}
