<?php

function isLoggedIn(): bool
{
    return isset($_SESSION['user']);
}

function isVendeur(): bool
{
    return isset($_SESSION['user']) && $_SESSION['user']['typePerson'] === 'VENDEUR';
}

function isClient(): bool
{
    return isset($_SESSION['user']) && $_SESSION['user']['typePerson'] === 'CLIENT';
}

function runMiddleware($middlewares): void
{
    if (!$middlewares) {
        return;
    }

    foreach ($middlewares as $middleware) {
        if (!function_exists($middleware)) {
            header("Location:" . $_ENV['APP_URL']);
            exit;
        }
        
        if (!$middleware()) {
            header("Location:" . $_ENV['APP_URL']);
            exit;
        }
    }
}
