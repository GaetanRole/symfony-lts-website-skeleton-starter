<?php

declare(strict_types=1);

putenv('APP_ENV='.$_SERVER['APP_ENV'] = $_ENV['APP_ENV'] = 'test');
require dirname(__DIR__, 2).'/config/bootstrap.php';
