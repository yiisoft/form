<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Yiisoft\Form\Field;

/**
 * @var array $params
 */

return [
    static function (ContainerInterface $container) use ($params) {
        Field::initialize(
            $params['yiisoft/form']['configs'],
            $params['yiisoft/form']['defaultConfig'],
        );
    },
];
