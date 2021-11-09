<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Tests\TestSupport\Form\TypeForm;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Widget\Field;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class FieldNumberTest extends TestCase
{
    use TestTrait;

    private TypeForm $formModel;

    public function testMax(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-number">Number</label>
        <input type="number" id="typeform-number" name="TypeForm[number]" max="8">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->formModel, 'number')->number(['max' => 8])->render(),
        );
    }

    public function testMin(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-number">Number</label>
        <input type="number" id="typeform-number" name="TypeForm[number]" min="4">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->formModel, 'number')->number(['min' => 4])->render(),
        );
    }

    public function testPlaceholder(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-number">Number</label>
        <input type="number" id="typeform-number" name="TypeForm[number]" placeholder="PlaceHolder Text">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->config($this->formModel, 'number')
                ->number(['placeholder' => 'PlaceHolder Text'])
                ->render(),
        );
    }

    public function testRender(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-number">Number</label>
        <input type="number" id="typeform-number" name="TypeForm[number]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->formModel, 'number')->number()->render(),
        );
    }

    public function testValue(): void
    {
        // value null
        $expected = <<<'HTML'
        <div>
        <label for="typeform-number">Number</label>
        <input type="number" id="typeform-number" name="TypeForm[number]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->formModel, 'number')->number()->render(),
        );

        // int value 1
        $this->formModel->setAttribute('number', 1);
        $expected = <<<'HTML'
        <div>
        <label for="typeform-number">Number</label>
        <input type="number" id="typeform-number" name="TypeForm[number]" value="1">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->formModel, 'number')->number()->render(),
        );

        // string numeric value '1'
        $this->formModel->setAttribute('string', 1);
        $expected = <<<'HTML'
        <div>
        <label for="typeform-string">String</label>
        <input type="number" id="typeform-string" name="TypeForm[string]" value="1" placeholder="Typed your text string.">
        <div>Write your text string.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->formModel, 'string')->number()->render(),
        );
    }

    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Number widget must be a numeric or null value.');
        Field::widget()->config($this->formModel, 'array')->number()->render();
    }

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer(), []);
        $this->createFormModel(TypeForm::class);
    }
}
