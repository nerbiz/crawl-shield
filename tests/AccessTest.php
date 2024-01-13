<?php

it('allows access with correct password', function () {
    $response = $this->get('/?pass=abc123');
    $response->assertStatus(200);
});

it('denies access with incorrect password', function () {
    $response = $this->get('/?pass=abc');
    $response->assertStatus(403);
});

it('denies access without a password', function () {
    $response = $this->get('/');
    $response->assertStatus(403);
});
