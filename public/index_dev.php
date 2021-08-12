<?php

use App\Kernel;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

return function (array $context) {
    if (!isset($_COOKIE['dev_key']) || $_COOKIE['dev_key'] !== $context['APP_SECRET']) {
        header('HTTP/1.0 403 Forbidden');
        exit('You are not allowed to access this file.');
    }
    return new Kernel('dev', true);
};
