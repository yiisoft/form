<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Yiisoft\Form\FormFields;

/**
 * @var array $params
 */

return [
    static function (ContainerInterface $container) use ($params) {
        FormFields::initialize(
            $params['yiisoft/form']['configs'],
            $params['yiisoft/form']['defaultConfig'],
        );
    },
];
