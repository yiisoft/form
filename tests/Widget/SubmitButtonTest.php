<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Tests\TestSupport\Form\TypeForm;
use Yiisoft\Form\Widget\SubmitButton;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class SubmitButtonTest extends TestCase
{
    private TypeForm $formModel;

    public function testAutoIdPrefix(): void
    {
        SubmitButton::counter(0);

        $this->assertSame(
            '<input type="submit" id="s0" name="s0">',
            SubmitButton::widget()->autoIdPrefix('s')->render(),
        );
    }

    public function testAttributes(): void
    {
        SubmitButton::counter(0);

        $this->assertSame(
            '<input type="submit" id="submit-0" name="submit-0" tabindex="5">',
            SubmitButton::widget()->attributes(['tabindex' => 5])->render(),
        );
    }

    public function testId(): void
    {
        SubmitButton::counter(0);

        $this->assertSame(
            '<input type="submit" id="test-id" name="test-id">',
            SubmitButton::widget()->id('test-id')->render(),
        );
    }

    public function testName(): void
    {
        SubmitButton::counter(0);

        $this->assertSame(
            '<input type="submit" id="submit-0" name="test-name">',
            SubmitButton::widget()->name('test-name')->render(),
        );
    }

    public function testRender(): void
    {
        SubmitButton::counter(0);

        $this->assertSame(
            '<input type="submit" id="submit-0" name="submit-0">',
            SubmitButton::widget()->render(),
        );
    }

    public function testValue(): void
    {
        SubmitButton::counter(0);

        $this->assertSame(
            '<input type="submit" id="submit-0" name="submit-0" value="Submit">',
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
