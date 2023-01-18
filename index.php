<?php

// fixit cool art text and credits/version header

use Slim\Factory\AppFactory;
// fixit vphp
use Slime\db;
use Slime\render;

require __DIR__ . '/vendor/autoload.php';
require 'settings.php';

$app = AppFactory::create();

$app->addBodyParsingMiddleware();

$GLOBALS['database'] = isset($GLOBALS['settings']['database']) ? db::init($GLOBALS['settings']['database']) : false;

$errorMiddleware = $app->addErrorMiddleware(false, false, false);

$errorMiddleware->setErrorHandler(\Slim\Exception\HttpNotFoundException::class, function (
  \Psr\Http\Message\ServerRequestInterface $request,
  \Throwable $exception,
  bool $displayErrorDetails,
  bool $logErrors,
  bool $logErrorDetails
) {
  return render::hbs($request, new \Slim\Psr7\Response(), [
    'template' => '404',
    'status' => 404,
    'title' => '404 NOT FOUND',
  ]);
});

require 'controllers/index.php';

$app->run();
