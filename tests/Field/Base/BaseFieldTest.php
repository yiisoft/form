<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field\Base;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Tests\Support\StubBaseField;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class BaseFieldTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer());
    }

    public function testBeginEnd(): void
    {
        $field = StubBaseField::widget();

        $result = $field->begin() . 'content' . StubBaseField::end();

        $this->assertSame('<div>content</div>', $result);
    }

    public function testBeginEndWithoutContainer(): void
    {
        $field = StubBaseField::widget()->useContainer(false);

        $result = $field->begin() . 'content' . StubBaseField::end();

        $this->assertSame('content', $result);
    }
}
