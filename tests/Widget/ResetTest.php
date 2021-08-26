<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Tests\TestSupport\Form\TypeForm;
use Yiisoft\Form\Widget\ResetButton;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class ResetTest extends TestCase
{
    private TypeForm $formModel;

    public function testAutoIdPrefix(): void
    {
        ResetButton::counter(0);
        $this->assertSame(
            '<input type="reset" id="w0" name="w0">',
            ResetButton::widget()->autoIdPrefix('w')->render(),
        );
    }

    public function testAttributes(): void
    {
        ResetButton::counter(0);
        $this->assertSame(
            '<input type="reset" id="reset-0" name="reset-0" disabled>',
            ResetButton::widget()->attributes(['disabled' => true])->render(),
        );
    }

    public function testId(): void
    {
        ResetButton::counter(0);
        $this->assertSame(
            '<input type="reset" id="test-id" name="test-id">',
            ResetButton::widget()->id('test-id')->render(),
        );
    }

    public function testName(): void
    {
        ResetButton::counter(0);
        $this->assertSame(
            '<input type="reset" id="reset-0" name="test-name">',
            ResetButton::widget()->name('test-name')->render(),
        );
    }

    public function testRender(): void
    {
        ResetButton::counter(0);
        $this->assertSame(
            '<input type="reset" id="reset-0" name="reset-0">',
            ResetButton::widget()->render(),
        );
    }

    public function testValue(): void
    {
        ResetButton::counter(0);
        $this->assertSame(
            '<input type="reset" id="reset-0" name="reset-0" value="Reseteable">',
            ResetButton::widget()->value('Reseteable')->render(),
        );
    }

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer(), []);
        $this->formModel = new TypeForm();
    }
}
