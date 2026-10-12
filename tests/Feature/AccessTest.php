<?php

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Nerbiz\CrawlShield\Middleware\CrawlShieldMiddleware;
use Symfony\Component\HttpKernel\Exception\HttpException;

it('allows access with a correct password', function () {
    Config::set('crawl-shield.parameter', 'password');
    Config::set('crawl-shield.password', 'abc');

    $request = Request::create('/?password=abc');
    $middleware = new CrawlShieldMiddleware();

    $response = $middleware->handle($request, fn () => new Response('Ok', 200));

    expect($response->getStatusCode())->toBe(200);
});

it('denies access with an incorrect password', function () {
    Config::set('crawl-shield.parameter', 'password');
    Config::set('crawl-shield.password', 'abc');

    $request = Request::create('/?password=wrong');
    $middleware = new CrawlShieldMiddleware();

    $middleware->handle($request, fn () => new Response('Ok', 200));
})->throws(HttpException::class);

it('denies access without a password', function () {
    Config::set('crawl-shield.parameter', 'password');
    Config::set('crawl-shield.password', 'abc');

    $request = Request::create('/');
    $middleware = new CrawlShieldMiddleware();

    $middleware->handle($request, fn () => new Response('Ok', 200));
})->throws(HttpException::class);

it('allows access when the shield is disabled', function () {
    Config::set('crawl-shield.enabled', false);

    $request = Request::create('/');
    $middleware = new CrawlShieldMiddleware();

    $response = $middleware->handle($request, fn () => new Response('Ok', 200));

    expect($response->getStatusCode())->toBe(200);
});

it('allows access with a remembered session', function () {
    Config::set('crawl-shield.parameter', 'password');
    Config::set('crawl-shield.password', 'abc');

    $request = Request::create('/?password=abc');
    $middleware = new CrawlShieldMiddleware();
    $next = fn () => new Response('Ok', 200);

    $middleware->handle($request, $next);

    $request = Request::create('/');
    $response = $middleware->handle($request, $next);

    expect($response->getStatusCode())->toBe(200);
});

it('denies access with an incorrect password despite a valid session', function () {
    Config::set('crawl-shield.parameter', 'password');
    Config::set('crawl-shield.password', 'abc');

    session()->put('crawl-shield-password', 'abc');

    $request = Request::create('/?password=wrong');
    $middleware = new CrawlShieldMiddleware();

    $middleware->handle($request, fn () => new Response('Ok', 200));
})->throws(HttpException::class);

it('denies access with an empty password despite a valid session', function () {
    Config::set('crawl-shield.parameter', 'password');
    Config::set('crawl-shield.password', 'abc');

    session()->put('crawl-shield-password', 'abc');

    $request = Request::create('/?password=');
    $middleware = new CrawlShieldMiddleware();

    $middleware->handle($request, fn () => new Response('Ok', 200));
})->throws(HttpException::class);
