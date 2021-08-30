<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Tests\TestSupport\Form\TypeForm;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Widget\SubmitButton;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class SubmitButtonTest extends TestCase
{
    use TestTrait;

    private TypeForm $formModel;

    public function testAutoIdPrefix(): void
    {
        $this->assertSame(
            '<input type="submit" id="s-1" name="s-1">',
            SubmitButton::widget()->autoIdPrefix('s-')->render(),
        );
    }

    public function testAttributes(): void
    {
        $this->assertSame(
            '<input type="submit" id="submit-1" name="submit-1" tabindex="5">',
            SubmitButton::widget()->attributes(['tabindex' => 5])->render(),
        );
    }

    public function testId(): void
    {
        $this->assertSame(
            '<input type="submit" id="test-id" name="test-id">',
            SubmitButton::widget()->id('test-id')->render(),
        );
    }

    public function testName(): void
    {
        $this->assertSame(
            '<input type="submit" id="submit-2" name="test-name">',
            SubmitButton::widget()->name('test-name')->render(),
        );
    }

    public function testRender(): void
    {
        $this->assertSame(
            '<input type="submit" id="submit-3" name="submit-3">',
            SubmitButton::widget()->render(),
        );
    }

    public function testValue(): void
    {
        $this->assertSame(
            '<input type="submit" id="submit-4" name="submit-4" value="Submit">',
            SubmitButton::widget()->value('Submit')->render(),
        );
    }

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer(), []);
        $this->formModel = new TypeForm();
    }
}
