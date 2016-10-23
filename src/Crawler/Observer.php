<?php

namespace IamKelvin\Sitemap\Crawler;

use IamKelvin\Crawler\CrawlObserver;
use IamKelvin\Crawler\Url;

class Observer implements CrawlObserver
{
    /** @var callable */
    protected $hasCrawled;

    public function __construct(callable $hasCrawled)
    {
        $this->hasCrawled = $hasCrawled;
    }

    /**
     * Called when the crawler will crawl the url.
     *
     * @param \IamKelvin\Crawler\Url $url
     */
    public function willCrawl(Url $url)
    {
    }

    /**
     * Called when the crawler has crawled the given url.
     *
     * @param \IamKelvin\Crawler\Url                      $url
     * @param \Psr\Http\Message\ResponseInterface|null $response
     */
    public function hasBeenCrawled(Url $url, $response)
    {
        ($this->hasCrawled)($url, $response);
    }

    /**
     * Called when the crawl has ended.
     */
    public function finishedCrawling()
    {
    }
}
