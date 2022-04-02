<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Yiisoft\Form\FieldStaticFactory;

/**
 * @var array $params
 */

return [
    static function (ContainerInterface $container) use ($params) {
        FieldStaticFactory::initialize(
            $params['yiisoft/form']['config'] ?? []
        );
    },
];
