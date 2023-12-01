<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\PureField;
use Yiisoft\Form\ThemeContainer;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class PureFieldTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer());
        ThemeContainer::initialize();
    }

    public function testTime(): void
    {
        $html = PureField::time()->render();

        $expected = <<<HTML
            <div>
            <input type="time">
            </div>
            HTML;

        $this->assertSame($expected, $html);
    }
}
