<?php

namespace IamKelvin\Sitemap;

use Psr\Http\Message\ResponseInterface;
use IamKelvin\Crawler\Crawler;
use IamKelvin\Crawler\Url as CrawlerUrl;
use IamKelvin\Sitemap\Crawler\Observer;
use IamKelvin\Sitemap\Crawler\Profile;
use IamKelvin\Sitemap\Tags\Url;

class SitemapGenerator
{
    /** @var \IamKelvin\Sitemap\Sitemap */
    protected $sitemap;

    /** @var string */
    protected $urlToBeCrawled = '';

    /** @var \IamKelvin\Crawler\Crawler */
    protected $crawler;

    /** @var callable */
    protected $shouldCrawl;

    /** @var callable */
    protected $hasCrawled;

    /**
     * @param string $urlToBeCrawled
     *
     * @return static
     */
    public static function create(string $urlToBeCrawled)
    {
        return app(static::class)->setUrl($urlToBeCrawled);
    }

    public function __construct(Crawler $crawler)
    {
        $this->crawler = $crawler;

        $this->sitemap = new Sitemap();

        $this->hasCrawled = function (Url $url, ResponseInterface $response = null) {
            return $url;
        };
    }

    public function setUrl(string $urlToBeCrawled)
    {
        $this->urlToBeCrawled = $urlToBeCrawled;

        return $this;
    }

    public function shouldCrawl(callable $shouldCrawl)
    {
        $this->shouldCrawl = $shouldCrawl;

        return $this;
    }

    public function hasCrawled(callable $hasCrawled)
    {
        $this->hasCrawled = $hasCrawled;

        return $this;
    }

    public function getSitemap(): Sitemap
    {
        $this->crawler
            ->setCrawlProfile($this->getCrawlProfile())
            ->setCrawlObserver($this->getCrawlObserver())
            ->startCrawling($this->urlToBeCrawled);

        return $this->sitemap;
    }

    /**
     * @param string $path
     *
     * @return $this
     */
    public function writeToFile(string $path)
    {
        $this->getSitemap()->writeToFile($path);

        return $this;
    }

    protected function getCrawlProfile(): Profile
    {
        $shouldCrawl = function (CrawlerUrl $url) {
            if ($url->host !== CrawlerUrl::create($this->urlToBeCrawled)->host) {
                return false;
            }

            if (! is_callable($this->shouldCrawl)) {
                return true;
            }

            return ($this->shouldCrawl)($url);
        };

        return new Profile($shouldCrawl);
    }

    protected function getCrawlObserver(): Observer
    {
        $performAfterUrlHasBeenCrawled = function (CrawlerUrl $crawlerUrl, ResponseInterface $response = null) {
            $sitemapUrl = ($this->hasCrawled)(Url::create($crawlerUrl), $response);

            if ($sitemapUrl) {
                $this->sitemap->add($sitemapUrl);
            }
        };

        return new Observer($performAfterUrlHasBeenCrawled);
    }
}
