<?php

declare(strict_types=1);

require __DIR__ . '/RouteX/RouteAction.php';
require __DIR__ . '/RouteX/RouteErrors.php';
require __DIR__ . '/RouteX/Route.php';
require __DIR__ . '/RouteX/MissingActionException.php';
require __DIR__ . '/RouteX/MissingControllerException.php';
require __DIR__ . '/RouteX/MissingActionArgumentException.php';
require __DIR__ . '/RouteX/RouteHandler.php';

use AlexKratky\Route;

Route::setError(Route::ERROR_NOT_FOUND, function() {
    die("Error 404");
});

Route::setError(Route::ERROR_FORBIDDEN, function() {
    die("Error 403");
});

Route::setError(Route::ERROR_MIDDLEWARE, function() {
    die("Middleware Error");
});

Route::setError(Route::ERROR_BAD_REQUEST, function() {
    die("Error 400");
});

Route::setError(Route::ERROR_INTERNAL_SERVER, function() {
    die("Error 500");
});