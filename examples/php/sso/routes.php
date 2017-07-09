<?php

$r->get('/', function () {
    include (__DIR__ . "/index.php");
});

$r->get('/sso/token/generate/{ssoId}', function ($URL_PARAMS) {
    include (__DIR__ . "/generate_token.php");
});

$r->get('/sso/token/verify', function () {
    include (__DIR__ . "/verify_token.php");
});
