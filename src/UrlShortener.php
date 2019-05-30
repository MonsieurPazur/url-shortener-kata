<?php

/**
 * Handles shortening urls and storing them in some database.
 */

namespace App;

/**
 * Class UrlShortener
 *
 * @package App
 */
class UrlShortener
{
    /**
     * @var string host for short urls
     */
    public const SHORT_HOST = 'short.url';

    /**
     * @var string domain used to access shorten urls
     */
    public const SHORT_URL = 'https://' . self::SHORT_HOST . '/';

    /**
     * @var string what hashing algorithm should be used
     */
    private const HASH_ALGORITHM = 'md5';

    /**
     * @var int how short should generated hash be
     */
    private const HASH_LENGTH = 8;

    /**
     * @var UrlDatabase $database where we store urls
     */
    private $database;

    /**
     * UrlShortener constructor.
     */
    public function __construct()
    {
        $this->database = new UrlDatabase();
    }

    /**
     * @param string $longUrl
     *
     * @return string
     */
    public function translate(string $longUrl): string
    {
        $hash = $this->shorten($longUrl);
        $this->database->insert($hash, $longUrl);
        return self::SHORT_URL . $hash;
    }

    /**
     * Retrieves long url from short url.
     *
     * @param string $shortUrl short url by which we retrieve long one
     *
     * @return string full url before it was shorten
     */
    public function retrieve(string $shortUrl): string
    {
        $hash = substr(parse_url($shortUrl, PHP_URL_PATH), 1);
        return $this->database->retrieveUrl($hash);
    }

    /**
     * Gets formatted statistics of given url (short or long).
     *
     * @param string $url short or long url
     *
     * @return string statistics in format: short | long | visits
     */
    public function getStats(string $url): string
    {
        if (self::SHORT_HOST === parse_url($url, PHP_URL_HOST)) {
            $hash = substr(parse_url($url, PHP_URL_PATH), 1);
        } else {
            $hash = $this->shorten($url);
        }
        return self::SHORT_URL . $hash
            . ' | '
            . $this->database->getUrl($hash)
            . ' | '
            . $this->database->getVisits($hash);
    }

    /**
     * Creates short hash from given url.
     *
     * @param string $longUrl
     *
     * @return string hash created from url
     */
    private function shorten(string $longUrl): string
    {
        // Hashing url and encoding.
        $hash = base64_encode(hash(self::HASH_ALGORITHM, $longUrl));

        // Only some first characters.
        $hash = substr($hash, 0, self::HASH_LENGTH);

        // Convert to lowercase.
        $hash = strtolower($hash);

        return $hash;
    }
}
