<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Support;

use Yiisoft\Form\FormHydrator;
use Yiisoft\Hydrator\Hydrator;
use Yiisoft\Hydrator\Validator\Attribute\ValidateResolver;
use Yiisoft\Hydrator\Validator\ValidatingHydrator;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Validator\Validator;

final class TestHelper
{
    public static function createFormHydrator(): FormHydrator
    {
        return new FormHydrator(self::createValidatingHydrator());
    }

    public static function createValidatingHydrator(): ValidatingHydrator
    {
        $validator = new Validator();
        return new ValidatingHydrator(
            self::createHydrator(),
            $validator,
            new ValidateResolver($validator),
        );
    }

    public static function createHydrator(): Hydrator
    {
        return new Hydrator(new SimpleContainer());
    }
}
