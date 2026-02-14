<?php

use Composer\Autoload\ClassLoader;

/**
 * @var ClassLoader $loader
 */
$loader = require __DIR__.'/../vendor/autoload.php';

if (file_exists(dirname(__DIR__).'/.env') || file_exists(dirname(__DIR__).'/.env.local')) {
    (new \Symfony\Component\Dotenv\Dotenv())->bootEnv(dirname(__DIR__).'/.env');
}

return $loader;
