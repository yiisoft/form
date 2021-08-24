<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Widget\Field;
use Yiisoft\Form\Widget\ResetButton;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class FieldResetTest extends TestCase
{
    use TestTrait;

    public function testAutoIdPrefix(): void
    {
        ResetButton::counter(0);
        $expected = <<<'HTML'
        <div>
        <input type="reset" id="w0" name="w0">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->resetButton(['autoIdPrefix' => 'w'])->render(),
        );
    }

    public function testAttributes(): void
    {
        ResetButton::counter(0);
        $expected = <<<'HTML'
        <div>
        <input type="reset" id="reset-0" name="reset-0" disabled>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->resetButton(['disabled' => true])->render(),
        );
    }

    public function testId(): void
    {
        ResetButton::counter(0);
        $expected = <<<'HTML'
        <div>
        <input type="reset" id="test-id" name="test-id">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->resetButton(['id' => 'test-id'])->render(),
        );
    }

    public function testName(): void
    {
        ResetButton::counter(0);
        $expected = <<<'HTML'
        <div>
        <input type="reset" id="reset-0" name="test-name">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->resetButton(['name' => 'test-name'])->render(),
        );
    }

    public function testRender(): void
    {
        ResetButton::counter(0);
        $expected = <<<'HTML'
        <div>
        <input type="reset" id="reset-0" name="reset-0">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->resetButton()->render(),
        );
    }

    public function testValue(): void
    {
        ResetButton::counter(0);
        $expected = <<<'HTML'
        <div>
        <input type="reset" id="reset-0" name="reset-0" value="Reseteable">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->resetButton(['value' => 'Reseteable'])->render(),
        );
    }

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer(), []);
    }
}
