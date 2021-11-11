<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget\Attribute;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Tests\TestSupport\Widget\InputAttributesWidget;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class InputAttributesTest extends TestCase
{
    public function testAutofocus(): void
    {
        $this->assertSame('<test autofocus>', InputAttributesWidget::widget()->autofocus()->render());
    }

    public function testDisabled(): void
    {
        $this->assertSame('<test disabled>', InputAttributesWidget::widget()->disabled()->render());
    }

    public function testForm(): void
    {
        $this->assertSame(
            '<test form="test-form-id">',
            InputAttributesWidget::widget()->form('test-form-id')->render(),
        );
    }

    public function testImmutability(): void
    {
        $inputAttributes = InputAttributesWidget::widget();
        $this->assertNotSame($inputAttributes, $inputAttributes->autofocus());
        $this->assertNotSame($inputAttributes, $inputAttributes->disabled());
        $this->assertNotSame($inputAttributes, $inputAttributes->form(''));
        $this->assertNotSame($inputAttributes, $inputAttributes->name(''));
        $this->assertNotSame($inputAttributes, $inputAttributes->readOnly());
        $this->assertNotSame($inputAttributes, $inputAttributes->required());
        $this->assertNotSame($inputAttributes, $inputAttributes->tabIndex());
        $this->assertNotSame($inputAttributes, $inputAttributes->value(null));
    }

    public function testName(): void
    {
        $this->assertSame('<test name="test-name">', InputAttributesWidget::widget()->name('test-name')->render());
    }

    public function testReadOnly(): void
    {
        $this->assertSame('<test readonly>', InputAttributesWidget::widget()->readOnly()->render());
    }

    public function testRequired(): void
    {
        $this->assertSame('<test required>', InputAttributesWidget::widget()->required()->render());
    }

    public function testTabIndex(): void
    {
        $this->assertSame('<test tabindex="5">', InputAttributesWidget::widget()->tabIndex(5)->render());
    }

    public function testValue(): void
    {
        $this->assertSame('<test value="1">', InputAttributesWidget::widget()->value(1)->render());
    }

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer(), []);
    }
}
