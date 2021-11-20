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

final class FieldPasswordTest extends TestCase
{
    use TestTrait;

    public function testAttributes(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-string">String</label>
        <input type="password" id="typeform-string" class="test-class" name="TypeForm[string]" placeholder="Typed your text string.">
        <div>Write your text string.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->for($this->formModel, 'string')->password(['class' => 'test-class'])->render(),
        );
    }

    public function testForm(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-string">String</label>
        <input type="password" id="typeform-string" name="TypeForm[string]" form="form-id" placeholder="Typed your text string.">
        <div>Write your text string.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->for($this->formModel, 'string')->password(['form' => 'form-id'])->render(),
        );
    }

    public function testMaxLength(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-string">String</label>
        <input type="password" id="typeform-string" name="TypeForm[string]" maxlength="16" placeholder="Typed your text string.">
        <div>Write your text string.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->for($this->formModel, 'string')->password(['maxlength' => 16])->render(),
        );
    }

    public function testMinLength(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-string">String</label>
        <input type="password" id="typeform-string" name="TypeForm[string]" minlength="8" placeholder="Typed your text string.">
        <div>Write your text string.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->for($this->formModel, 'string')->password(['minlength' => 8])->render(),
        );
    }

    public function testPattern(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-string">String</label>
        <input type="password" id="typeform-string" name="TypeForm[string]" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters." pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" placeholder="Typed your text string.">
        <div>Write your text string.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->for($this->formModel, 'string')
                ->password(
                    [
                        'pattern' => '(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}',
                        'title' => 'Must contain at least one number and one uppercase and lowercase letter, and at ' .
                        'least 8 or more characters.',
                    ]
                )
                ->render()
        );
    }

    public function testPlaceholder(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-string">String</label>
        <input type="password" id="typeform-string" name="TypeForm[string]" placeholder="PlaceHolder Text">
        <div>Write your text string.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->for($this->formModel, 'string')
                ->password(['placeholder' => 'PlaceHolder Text'])
                ->render(),
        );
    }

    public function testReadOnly(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-string">String</label>
        <input type="password" id="typeform-string" name="TypeForm[string]" readonly placeholder="Typed your text string.">
        <div>Write your text string.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->for($this->formModel, 'string')->password(['readonly' => true])->render(),
        );
    }

    public function testRender(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-string">String</label>
        <input type="password" id="typeform-string" name="TypeForm[string]" placeholder="Typed your text string.">
        <div>Write your text string.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->for($this->formModel, 'string')->password()->render(),
        );
    }

    public function testValue(): void
    {
        // value null
        $expected = <<<'HTML'
        <div>
        <label for="typeform-tonull">To Null</label>
        <input type="password" id="typeform-tonull" name="TypeForm[toNull]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->for($this->formModel, 'toNull')->password()->render(),
        );

        // value string
        $this->formModel->setAttribute('string', '1234??');
        $expected = <<<'HTML'
        <div>
        <label for="typeform-string">String</label>
        <input type="password" id="typeform-string" name="TypeForm[string]" value="1234??" placeholder="Typed your text string.">
        <div>Write your text string.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->for($this->formModel, 'string')->password()->render(),
        );
    }

    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Password widget must be a string or null value.');
        Field::widget()->for($this->formModel, 'array')->password()->render();
    }

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer(), []);
        $this->createFormModel(TypeForm::class);
    }
}
