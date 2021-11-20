<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget\Attribute;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Tests\TestSupport\Form\TypeForm;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Tests\TestSupport\Widget\GlobalAttributesWidget;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class GlobalAttributesTest extends TestCase
{
    use TestTrait;

    public function testAutofocus(): void
    {
        $this->assertSame('<test autofocus>', GlobalAttributesWidget::widget()->autofocus()->render());
    }

    public function testgetIdWithoutModelException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Attribute "id" must be a string or null.');
        $this->invokeMethod(GlobalAttributesWidget::widget()->attributes(['id' => true]), 'getIdWithoutModel');
    }

    public function testDisable(): void
    {
        $this->assertSame('<test disabled>', GlobalAttributesWidget::widget()->disabled()->render());
    }

    public function testId(): void
    {
        $this->assertSame('<test id="test-id">', GlobalAttributesWidget::widget()->id('test-id')->render());
    }

    public function testIdWithNull(): void
    {
        $this->assertSame('<test>', GlobalAttributesWidget::widget()->id(null)->render());
    }

    public function testImmutability(): void
    {
        $inputAttributesWidget = GlobalAttributesWidget::widget();
        $this->assertNotSame($inputAttributesWidget, $inputAttributesWidget->autofocus());
        $this->assertNotSame($inputAttributesWidget, $inputAttributesWidget->id(null));
        $this->assertNotSame($inputAttributesWidget, $inputAttributesWidget->name(''));
        $this->assertNotSame($inputAttributesWidget, $inputAttributesWidget->tabindex(0));
        $this->assertNotSame($inputAttributesWidget, $inputAttributesWidget->title(''));
        $this->assertNotSame($inputAttributesWidget, $inputAttributesWidget->value(''));
    }

    public function testName(): void
    {
        $this->assertSame('<test name="test-name">', GlobalAttributesWidget::widget()->name('test-name')->render());
    }

    public function testRequired(): void
    {
        $this->assertSame('<test required>', GlobalAttributesWidget::widget()->required()->render());
    }

    public function testTabIndex(): void
    {
        $this->assertSame('<test tabindex="1">', GlobalAttributesWidget::widget()->tabIndex(1)->render());
    }

    public function testTitle(): void
    {
        $this->assertSame('<test title="test-title">', GlobalAttributesWidget::widget()->title('test-title')->render());
    }

    public function testValue(): void
    {
        $this->assertSame('<test value="0">', GlobalAttributesWidget::widget()->value(0)->render());
    }

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer(), []);
        $this->createFormModel(TypeForm::class);
    }
}
