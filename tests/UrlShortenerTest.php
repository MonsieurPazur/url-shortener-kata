<?php

/**
 * Test suite for shortening urls functionalities.
 */

namespace Test;

use App\UrlShortener;
use Generator;
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
     *
     * @dataProvider shortUrlsProvider
     *
     * @param string $url url to shorten
     * @param string $expected short url
     */
    public function testShorteningUrl(string $url, string $expected): void
    {
        $shortUrl = $this->shortener->translate($url);
        $this->assertEquals($expected, $shortUrl);
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
     *
     * @dataProvider statsProvider
     *
     * @param string $longUrl url to shorten in the first place
     * @param string $statsUrl url used to get statistics
     * @param int $visited number of times this url was visited
     * @param string $expected formatted statistics
     */
    public function testStatistics(string $longUrl, string $statsUrl, int $visited, string $expected): void
    {
        $url = $this->shortener->translate($longUrl);

        for ($i = 0; $i < $visited; $i++) {
            $this->shortener->retrieve($url);
        }

        $stats = $this->shortener->getStats($statsUrl);
        $this->assertEquals($expected, $stats);
    }

    /**
     * Provides data for shortening urls.
     *
     * @return Generator
     */
    public function shortUrlsProvider(): Generator
    {
        yield 'basic url' => [
            'url' => 'https://some-long-url.com/something',
            'expected' => 'https://short.url/otu5ngy1'
        ];
        yield 'already shorten url' => [
            'url' => 'https://short.url/otu5ngy1',
            'expected' => 'https://short.url/n2yxztq1'
        ];
        yield 'very long url' => [
            'url' => 'https://www.google.pl/search?q=whatever&oq=whatever&aqs=chrome',
            'expected' => 'https://short.url/zdhjn2m3'
        ];
    }

    /**
     * Provides data for generating statistics.
     *
     * @return Generator
     */
    public function statsProvider(): Generator
    {
        yield 'visited 6 times' => [
            'longUrl' => 'https://some-long-url.com/something',
            'statsUrl' => 'https://short.url/otu5ngy1',
            'visited' => 6,
            'expected' => 'https://short.url/otu5ngy1 | https://some-long-url.com/something | 6'
        ];
        yield 'visited 9 times' => [
            'longUrl' => 'https://some-long-url.com/something',
            'statsUrl' => 'https://some-long-url.com/something',
            'visited' => 9,
            'expected' => 'https://short.url/otu5ngy1 | https://some-long-url.com/something | 9'
        ];
    }
}
