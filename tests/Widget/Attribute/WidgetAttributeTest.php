<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget\Attribute;

use PHPUnit\Framework\TestCase;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;
use Yiisoft\Form\Exception\AttributeNotSetException;
use Yiisoft\Form\Exception\FormModelNotSetException;
use Yiisoft\Form\Tests\TestSupport\Form\TypeForm;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Widget\Attribute\WidgetAttributes;

final class WidgetAttributeTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetAttributeNotSetException(): void
    {
        $widgetAttributes = $this->createWidget();
        $this->expectException(AttributeNotSetException::class);
        $this->expectExceptionMessage('Failed to create widget because attribute is not set.');
        $this->invokeMethod($widgetAttributes, 'getAttribute');
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetFormModelException(): void
    {
        $widgetAttributes = $this->createWidget();
        $this->expectException(FormModelNotSetException::class);
        $this->expectExceptionMessage('Failed to create widget because form model is not set.');
        $this->invokeMethod($widgetAttributes, 'getFormModel');
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testImmutability(): void
    {
        $widgetAttributes = $this->createWidget();
        $this->assertNotSame($widgetAttributes, $widgetAttributes->for(new TypeForm(), 'attribute'));
    }

    private function createWidget(): WidgetAttributes
    {
        return new class () extends WidgetAttributes {
            protected function run(): string
            {
                return '';
            }
        };
    }
}
