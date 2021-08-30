<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Tests\TestSupport\Form\TypeForm;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Widget\ResetButton;
use Yiisoft\Html\Html;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class ResetButtonTest extends TestCase
{
    use TestTrait;

    private TypeForm $formModel;

    public function testAutoIdPrefix(): void
    {
        $this->assertSame(
            '<input type="reset" id="r-1" name="r-1">',
            ResetButton::widget()->autoIdPrefix('r-')->render(),
        );
    }

    public function testAttributes(): void
    {
        $this->assertSame(
            '<input type="reset" id="reset-1" name="reset-1" disabled>',
            ResetButton::widget()->attributes(['disabled' => true])->render(),
        );
    }

    public function testId(): void
    {
        $this->assertSame(
            '<input type="reset" id="test-id" name="test-id">',
            ResetButton::widget()->id('test-id')->render(),
        );
    }

    public function testName(): void
    {
        $this->assertSame(
            '<input type="reset" id="reset-1" name="test-name">',
            ResetButton::widget()->name('test-name')->render(),
        );
    }

    public function testRender(): void
    {
        $this->assertSame(
            '<input type="reset" id="reset-1" name="reset-1">',
            ResetButton::widget()->render(),
        );
    }

    public function testValue(): void
    {
        $this->assertSame(
            '<input type="reset" id="reset-1" name="reset-1" value="Reseteable">',
            ResetButton::widget()->value('Reseteable')->render(),
        );
    }

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer(), []);
        $this->formModel = new TypeForm();
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
    }
}
