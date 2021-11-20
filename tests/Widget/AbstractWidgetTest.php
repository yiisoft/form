<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Tests\TestSupport\Form\TypeForm;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Widget\AbstractWidget;
use Yiisoft\Form\Widget\Attribute\GlobalAttributes;
use Yiisoft\Html\Html;

final class AbstractWidgetTest extends TestCase
{
    use TestTrait;

    public function testAddAttribute(): void
    {
        $abstractWidget = $this->createAbstractWidget();
        $this->assertSame('<test class="test">', $abstractWidget->addAttribute('class', 'test')->render());
    }

    public function testGetAttributeException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Attribute is not set.');
        $this->invokeMethod($this->createAbstractWidget(), 'getAttribute');
    }

    public function testGetFormModelException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Form model is not set.');
        $this->invokeMethod($this->createAbstractWidget(), 'getFormModel');
    }

    public function testGetIdException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Attribute "id" must be a string or null.');
        $abstractWidget = $this->createAbstractWidget();
        $abstractWidget = $abstractWidget->attributes(['id' => true]);
        $this->invokeMethod($abstractWidget, 'getId');
    }

    public function testGetNameException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Attribute "name" must be a string.');
        $abstractWidget = $this->createAbstractWidget();
        $abstractWidget = $abstractWidget->for(new TypeForm(), 'string')->attributes(['name' => true]);
        $this->invokeMethod($abstractWidget, 'getName');
    }

    private function createAbstractWidget(): AbstractWidget
    {
        return new class () extends AbstractWidget {
            use GlobalAttributes;

            public function run(): string
            {
                return '<test' . Html::renderTagAttributes($this->attributes) . '>';
            }
        };
    }
}
