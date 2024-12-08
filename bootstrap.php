<?php

use Core\App;
use Core\Database;
use Core\Container;

$container = new Container();

$container->bind('Core\Database', function () {
    // Connect to our MySQL database.
    $config = require base_path('config.php');

    return new Database($config['database']);
});

App::setContainer($container);