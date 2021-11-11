<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget\Attribute;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Tests\TestSupport\Widget\WithoutModelAttributeWidget;
use Yiisoft\Html\Html;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class WithoutModelAttributeTest extends TestCase
{
    use TestTrait;

    public function testAutoIdPrefix(): void
    {
        $this->assertSame(
            '<test id="t-1" name="t-1">',
            WithoutModelAttributeWidget::widget()->autoIdPrefix('t-')->render(),
        );
    }

    public function testAttributes(): void
    {
        $this->assertSame(
            '<test id="1" name="1" disabled>',
            WithoutModelAttributeWidget::widget()->attributes(['disabled' => true])->render(),
        );
    }

    public function testId(): void
    {
        $this->assertSame(
            '<test id="test-id" name="test-id">',
            WithoutModelAttributeWidget::widget()->id('test-id')->render(),
        );
    }

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer(), []);
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
    }
}
