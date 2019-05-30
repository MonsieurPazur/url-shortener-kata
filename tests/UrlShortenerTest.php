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
     * Tests shortening urls.
     */
    public function testShorteningUrl(): void
    {
        $urlShortener = new UrlShortener();
        $shortUrl = $urlShortener->translate('https://some-long-url.com/something');

        $this->assertEquals('https://short.url/otu5ngy1', $shortUrl);
    }
}
