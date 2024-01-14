<?php

use Illuminate\Http\Request;
use Nerbiz\CrawlShield\Middleware\CrawlShieldMiddleware;

it('allows access with correct password', function () {
    $request = Request::create('/?pass=abc123');
    $middleware = new CrawlShieldMiddleware();
    $response = $middleware->handle($request, fn () => response('Ok', 200));

    expect($response->getStatusCode())->toBe(200);
});

it('denies access with incorrect password', function () {
    $request = Request::create('/?pass=wrong');
    $middleware = new CrawlShieldMiddleware();
    $middleware->handle($request, fn () => response('Ok', 200));
})->throws(\Symfony\Component\HttpKernel\Exception\HttpException::class);

it('denies access without a password', function () {
    $request = Request::create('/');
    $middleware = new CrawlShieldMiddleware();
    $middleware->handle($request, fn () => response('Ok', 200));
})->throws(\Symfony\Component\HttpKernel\Exception\HttpException::class);
