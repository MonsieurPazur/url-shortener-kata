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
     * @var string domain used to access shorten urls
     */
    public const SHORT_URL = 'https://short.url/';

    /**
     * @var string what hashing algorithm should be used
     */
    private const HASH_ALGORITHM = 'md5';

    /**
     * @var int how short should generated hash be
     */
    private const HASH_LENGTH = 8;

    /**
     * @param string $longUrl
     *
     * @return string
     */
    public function translate(string $longUrl): string
    {
        return self::SHORT_URL . $this->shorten($longUrl);
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
