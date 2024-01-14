# Crawl shield

Prevent search engine crawlers from accessing your online test environments, by using a very simple password mechanism.

### This is not in any way intended for security!

It will prevent crawlers from indexing your temporary testing environment and to a certain degree it also prevents unwanted visits, but don't use this for application security.

## The concept

A `?pass=...` requirement is added to your routes using middleware. This is easy to use and remember by you, but unknown to search engines.

The goal is to block all crawlers from seeing any content, in a way that always works. This is also disabled on production by default, so that indexing isn't accidentally blocked when it shouldn't be.

## Installation

Install this package using Composer:

```sh
composer require nerbiz/crawl-shield
```

## Usage

#### Configuration

If needed, you can add settings to your `.env` file.

The default values result in https://example.com/?pass=abc123, you change that parameter and password with these: 
- `CRAWL_SHIELD_PARAMETER` (default 'pass') 
- `CRAWL_SHIELD_PASSWORD` (default 'abc123')

You can also disable the mechanism, or make it active in production:
- `CRAWL_SHIELD_ENABLED` (default true)
- `CRAWL_SHIELD_ENABLED_IN_PRODUCTION` (default false)

#### Add middleware

Add the below to the `$middlewareAliases` in your `App\Http\Kernel` class:

```php
'crawl-shield' => \Nerbiz\CrawlShield\Middleware\CrawlShieldMiddleware::class,
```

Then add the `crawl-shield` middleware to any routes that need it.

## Result

If you visit https://your-app, it will return a 403 status, if it's in a development environment. You can then bypass this 403 by visiting http://your-app/?pass=abc123. This is remembered in the session, so you don't need the password in every route afterwards.
