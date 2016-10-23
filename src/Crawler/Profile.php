<?php

namespace IamKelvin\Sitemap\Crawler;

use IamKelvin\Crawler\CrawlProfile;
use IamKelvin\Crawler\Url;

class Profile implements CrawlProfile
{
    public function __construct(callable $profile)
    {
        $this->profile = $profile;
    }

    /**
     * Determine if the given url should be crawled.
     *
     * @param \IamKelvin\Crawler\Url $url
     *
     * @return bool
     */
    public function shouldCrawl(Url $url)
    {
        return ($this->profile)($url);
    }
}
