<?php

declare(strict_types=1);

use Yiisoft\Form\ThemePath;

require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

$params = [
    'name' => 'Bootstrap 5 Vertical',
    'file' => ThemePath::BOOTSTRAP5_VERTICAL,
    'head' => '<link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">',
];

require dirname(__DIR__) . '/template.php';
