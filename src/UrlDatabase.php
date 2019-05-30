<?php

/**
 * Handles storing urls.
 */

namespace App;

/**
 * Class UrlDatabase
 *
 * @package App
 */
class UrlDatabase
{
    /**
     * @var array $data all information is being kept here
     */
    private $data;

    /**
     * UrlDatabase constructor.
     */
    public function __construct()
    {
        $this->data = [];
    }

    /**
     * Gets long url from database based on short url's hash.
     *
     * @param string $hash hash from short url, key in database array
     *
     * @return string long url or empty string if not found
     */
    public function getUrl(string $hash): string
    {
        return isset($this->data[$hash]) ? $this->data[$hash]['url'] : '';
    }

    /**
     * Inserts long url under short url's hash.
     *
     * @param string $hash key under which we save url
     * @param string $url long url to save
     */
    public function insert(string $hash, string $url): void
    {
        $this->data[$hash]['url'] = $url;
    }
}
