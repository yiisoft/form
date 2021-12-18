<?php

declare(strict_types=1);

namespace Yiisoft\Form;

use RuntimeException;

final class FieldStaticFactory
{
    private static ?FieldFactory $factory = null;

    private function __construct()
    {
    }

    public static function initialize(?FieldFactoryConfig $config = null): void
    {
        self::$factory = new FieldFactory(
            $config ?? new FieldFactoryConfig()
        );
    }

    public static function factory(): FieldFactory
    {
        if (self::$factory === null) {
            throw new RuntimeException(
                'Field factory should be initialized with FieldStaticFactory::initialize() call.',
            );
        }

        return self::$factory;
    }
}
