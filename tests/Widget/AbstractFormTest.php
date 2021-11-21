<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Tests\TestSupport\Form\TypeForm;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Widget\AbstractForm;
use Yiisoft\Form\Widget\Attribute\GlobalAttributes;
use Yiisoft\Html\Html;

final class AbstractFormTest extends TestCase
{
    use TestTrait;

    public function testAddAttribute(): void
    {
        $abstractForm = $this->createAbstractWidget();
        $this->assertSame('<test class="test">', $abstractForm->addAttribute('class', 'test')->render());
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
        $abstractForm = $this->createAbstractWidget();
        $abstractForm = $abstractForm->attributes(['id' => true]);
        $this->invokeMethod($abstractForm, 'getId');
    }

    public function testGetNameException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Attribute "name" must be a string.');
        $abstractForm = $this->createAbstractWidget();
        $abstractForm = $abstractForm->for(new TypeForm(), 'string')->attributes(['name' => true]);
        $this->invokeMethod($abstractForm, 'getName');
    }

    private function createAbstractWidget(): AbstractForm
    {
        return new class () extends AbstractForm {
            use GlobalAttributes;

            public function run(): string
            {
                return '<test' . Html::renderTagAttributes($this->attributes) . '>';
            }
        };
    }
}
