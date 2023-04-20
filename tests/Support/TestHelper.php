<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Support;

use Vjik\InputHydrator\Hydrator;
use Yiisoft\Form\FormHydrator;
use Yiisoft\Test\Support\Container\SimpleContainer;

final class TestHelper
{
    public static function createFormHydrator(): FormHydrator
    {
        return new FormHydrator(self::createHydrator());
    }

    public static function createHydrator(): Hydrator
    {
        return new Hydrator(new SimpleContainer());
    }
}
