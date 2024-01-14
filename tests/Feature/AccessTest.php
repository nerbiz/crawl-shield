<?php

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Nerbiz\CrawlShield\Middleware\CrawlShieldMiddleware;
use Symfony\Component\HttpKernel\Exception\HttpException;

it('allows access with correct password', function () {
    $request = Request::create('/?pass=abc123');
    $middleware = new CrawlShieldMiddleware();
    $response = $middleware->handle($request, fn () => new Response('Ok', 200));

    expect($response->getStatusCode())->toBe(200);
});

it('denies access with incorrect password', function () {
    $request = Request::create('/?pass=wrong');
    $middleware = new CrawlShieldMiddleware();
    $middleware->handle($request, fn () => new Response('Ok', 200));
})->throws(HttpException::class);

it('denies access without a password', function () {
    $request = Request::create('/');
    $middleware = new CrawlShieldMiddleware();
    $middleware->handle($request, fn () => new Response('Ok', 200));
})->throws(HttpException::class);
