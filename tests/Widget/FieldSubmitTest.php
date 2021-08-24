<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Widget\Field;
use Yiisoft\Form\Widget\SubmitButton;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class FieldSubmitTest extends TestCase
{
    use TestTrait;

    public function testAutoIdPrefix(): void
    {
        SubmitButton::counter(0);
        $expected = <<<'HTML'
        <div>
        <input type="submit" id="w0" name="w0">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->submitButton(['autoIdPrefix' => 'w'])->render(),
        );
    }

    public function testAttributes(): void
    {
        SubmitButton::counter(0);
        $expected = <<<'HTML'
        <div>
        <input type="submit" id="submit-0" name="submit-0" disabled>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->submitButton(['disabled' => true])->render(),
        );
    }

    public function testId(): void
    {
        SubmitButton::counter(0);
        $expected = <<<'HTML'
        <div>
        <input type="submit" id="test-id" name="test-id">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->submitButton(['id' => 'test-id'])->render(),
        );
    }

    public function testName(): void
    {
        SubmitButton::counter(0);
        $expected = <<<'HTML'
        <div>
        <input type="submit" id="submit-0" name="test-name">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->submitButton(['name' => 'test-name'])->render(),
        );
    }

    public function testRender(): void
    {
        SubmitButton::counter(0);
        $expected = <<<'HTML'
        <div>
        <input type="submit" id="submit-0" name="submit-0">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->submitButton()->render(),
        );
    }

    public function testValue(): void
    {
        SubmitButton::counter(0);
        $expected = <<<'HTML'
        <div>
        <input type="submit" id="submit-0" name="submit-0" value="Save">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->submitButton(['value' => 'Save'])->render(),
        );
    }

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer(), []);
    }
}
