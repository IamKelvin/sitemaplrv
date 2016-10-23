# Generate sitemaps with ease

[![Latest Version on Packagist](https://img.shields.io/packagist/v/IamKelvin/sitemaplrv.svg?style=flat-square)](https://packagist.org/packages/IamKelvin/sitemaplrv)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/8b8a2545-76b3-4f24-bf35-64e49adfa2cf.svg?style=flat-square)](https://insight.sensiolabs.com/projects/8b8a2545-76b3-4f24-bf35-64e49adfa2cf)
[![Quality Score](https://img.shields.io/scrutinizer/g/IamKelvin/laravel-sitemap.svg?style=flat-square)](https://scrutinizer-ci.com/g/IamKelvin/sitemaplrv)
[![StyleCI](https://styleci.io/repos/65549848/shield)](https://styleci.io/repos/65549848)
[![Total Downloads](https://img.shields.io/packagist/dt/IamKelvin/laravel-sitemap.svg?style=flat-square)](https://packagist.org/packages/IamKelvin/sitemaplrv)

This package can generate a sitemap without you having to add urls to it manually. This works by crawling your entire site.

## Installation

First, install the package via composer:

``` bash
composer require IamKelvin/laravel-sitemap
```

Next up: installing the service provider

```php
// config/app.php
'providers' => [
    ...
    IamKelvin\Sitemap\SitemapServiceProvider::class,
];
```

## Usage

### Generating a sitemap

The easiest way is to crawl the given domain and generate a sitemap with all found links.
The destination of the sitemap should be specified by `$path`.

```php
SitemapGenerator::create('https://example.com')->writeToFile($path);
```

The generated sitemap will look similiar to this:

```xml
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>https://example.com</loc>
        <lastmod>2016-01-01T00:00:00+00:00</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>https://example.com/page</loc>
        <lastmod>2016-01-01T00:00:00+00:00</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.8</priority>
    </url>

    ...
</urlset>
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.