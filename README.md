# Crawl Shield

A lightweight Laravel package that restricts access to your application using a simple URL parameter.

Crawl Shield helps keep unwanted visitors and search engine crawlers out, while allowing visitors with the correct parameter to browse freely once access has been granted.

**⚠️ Warning:** Crawl Shield is not a security solution. It discourages unwanted access but does not protect sensitive information or guarantee exclusion from search results.

## Installation

```bash
composer require nerbiz/crawl-shield
```

## Configuration

Crawl Shield works out of the box. To customise its behaviour, add any of the following variables to your `.env` file:

```dotenv
CRAWL_SHIELD_PARAMETER=pass
CRAWL_SHIELD_PASSWORD=abc123
CRAWL_SHIELD_ENABLED=true
CRAWL_SHIELD_ENABLED_IN_PRODUCTION=false
```

These are the default values. **You are strongly advised to change `CRAWL_SHIELD_PARAMETER` and `CRAWL_SHIELD_PASSWORD` in your `.env` file**, as the defaults are publicly known.

You can optionally publish the configuration file:

```bash
php artisan vendor:publish --tag=crawl-shield
```

This is not required, because all settings can be customised through environment variables.

## Middleware registration

Register the middleware in `bootstrap/app.php` using one of the following approaches.

### Option 1: Web routes (recommended)

Protect all routes using Laravel's `web` middleware group:

```php
use Illuminate\Foundation\Configuration\Middleware;
use Nerbiz\CrawlShield\Middleware\CrawlShieldMiddleware;

->withMiddleware(function (Middleware $middleware) {
    $middleware->web(append: [
        CrawlShieldMiddleware::class,
    ]);
})
```

### Option 2: Specific routes

Register an alias in `bootstrap/app.php`:

```php
use Illuminate\Foundation\Configuration\Middleware;
use Nerbiz\CrawlShield\Middleware\CrawlShieldMiddleware;

->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'crawl-shield' => CrawlShieldMiddleware::class,
    ]);
})
```

Then apply it to individual routes or groups:

```php
Route::get('/preview', fn () => view('preview'))
    ->middleware('crawl-shield');
```

These routes must use Laravel's `web` middleware group for session support.

## Usage

Without the correct query parameter, visitors receive an HTTP `403 Forbidden` response.

To gain access, visit:

```text
https://example.com/?pass=abc123
```

Access is then remembered in the session, so the parameter isn't needed for subsequent requests.

Crawl Shield is disabled in production by default.

## Limitations

Crawl Shield is a convenience barrier, not authentication. Anyone with the correct parameter can gain access, and the parameter may appear in browser history, logs or shared URLs.

Although crawlers receive a `403` response, this does not guarantee that URLs won't appear in search results.

For sensitive environments, use proper authentication or network-level access restrictions.
