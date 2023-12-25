<?php

declare(strict_types=1);

use Yiisoft\Form\PureField;
use Yiisoft\Form\ThemeContainer;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

$root = dirname(__DIR__, 2);

require_once $root . '/vendor/autoload.php';

WidgetFactory::initialize(new SimpleContainer());
ThemeContainer::initialize(
    [
        'bootstrap5-vertical' => require $root . '/config/theme-bootstrap5-vertical.php',
    ],
    'bootstrap5-vertical',
);

echo '<!DOCTYPE html>';
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yii Form — Bootstrap5 Vertical Theme</title>
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
</head>
<body>
<div style="max-width: 1000px;padding: 24px;margin: 0 auto">
    <?php
    echo PureField::text()->label('Text Field')->placeholder('Placeholder')->hint('Example of hint');
    echo PureField::text()->label('Invalid Text Field')->placeholder('Placeholder')->error('err');
    echo PureField::textarea()->label('Textarea Field')->placeholder('Placeholder');
    echo PureField::checkbox()->label('Checkbox Field');
    echo PureField::password()->label('Password Field')->placeholder('Placeholder');
    echo PureField::url()->label('Url Field')->placeholder('Placeholder');
    echo PureField::telephone()->label('Telephone Field')->placeholder('Placeholder');
    ?>
</div>
</body>
</html>
