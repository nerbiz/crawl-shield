# Crawl shield

Prevent search engine crawlers from accessing your online test environments, by using a very simple password mechanism.

### ⚠️ This is not in any way intended for security!

It will prevent crawlers from indexing your temporary testing environment and to a certain degree it also prevents unwanted visits, but don't use this for application security.

## The concept

A `?pass=...` requirement is added to your routes using middleware. This is easy to use and remember by you, but unknown to search engines.

The goal is to block all crawlers from indexing any test-environment content, in a way that always works. The mechanism is disabled on production by default.

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

If you wish to publish the config file to your own `config/` directory, use this command:

```sh
php artisan vendor:publish --tag=crawl-shield
```

#### Add middleware

You have several options to apply the middleware in `App\Http\Kernel`, depending on how you want to shield your routes.

```php
// Option 1: Shield all routes
protected $middleware = [
    // ...
    \Nerbiz\CrawlShield\Middleware\CrawlShieldMiddleware::class,
];

// Option 2: Shield only specific route group(s) 
protected $middlewareGroups = [
    'web' => [
        // ...
        \Nerbiz\CrawlShield\Middleware\CrawlShieldMiddleware::class,
    ],
    // ...
];

// Option 3: Custom usage in your routes/ directory
protected $middlewareAliases = [
    // ...
    'crawl-shield' => \Nerbiz\CrawlShield\Middleware\CrawlShieldMiddleware::class,
];
```

## Result

If you visit https://your-app, it will return a 403 status, if it's in a development environment. You can then bypass this 403 by visiting https://your-app/?pass=abc123. This is remembered in the session, so you don't need the password in every route afterwards.
