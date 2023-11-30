<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Yiisoft\Form\ThemeContainer;

/**
 * @var array $params
 */

return [
    static function (ContainerInterface $container) use ($params) {
        ThemeContainer::initialize(
            $params['yiisoft/form']['configs'],
            $params['yiisoft/form']['defaultConfig'],
            $params['yiisoft/form']['validationRulesEnrichmenter'],
        );
    },
];
