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
}
