<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field\Number;
use Yiisoft\Form\Tests\Support\Form\NumberForm;
use Yiisoft\Form\Tests\Support\StringableObject;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class NumberTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer());
    }

    public function testBase(): void
    {
        $result = Number::widget()
            ->formAttribute(new NumberForm(), 'age')
            ->render();

        $expected = <<<HTML
            <div>
            <label for="numberform-age">Your age</label>
            <input type="number" id="numberform-age" name="NumberForm[age]" value="42">
            <div>Full years.</div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function dataMax(): array
    {
        return [
            'int' => [
                '<input type="number" id="numberform-count" name="NumberForm[count]" max="42">',
                42,
            ],
            'string' => [
                '<input type="number" id="numberform-count" name="NumberForm[count]" max="53">',
                '53',
            ],
            'float' => [
                '<input type="number" id="numberform-count" name="NumberForm[count]" max="5.9">',
                '5.9',
            ],
            'Stringable' => [
                '<input type="number" id="numberform-count" name="NumberForm[count]" max="7">',
                new StringableObject('7'),
            ],
            'null' => [
                '<input type="number" id="numberform-count" name="NumberForm[count]">',
                null,
            ],
        ];
    }

    /**
     * @dataProvider dataMax
     */
    public function testMax(string $expected, $value): void
    {
        $result = Number::widget()
            ->formAttribute(new NumberForm(), 'count')
            ->hideLabel()
            ->useContainer(false)
            ->max($value)
            ->render();

        $this->assertSame($expected, $result);
    }

    public function dataMin(): array
    {
        return [
            'int' => [
                '<input type="number" id="numberform-count" name="NumberForm[count]" min="42">',
                42,
            ],
            'string' => [
                '<input type="number" id="numberform-count" name="NumberForm[count]" min="53">',
                '53',
            ],
            'float' => [
                '<input type="number" id="numberform-count" name="NumberForm[count]" min="5.9">',
                '5.9',
            ],
            'Stringable' => [
                '<input type="number" id="numberform-count" name="NumberForm[count]" min="7">',
                new StringableObject('7'),
            ],
            'null' => [
                '<input type="number" id="numberform-count" name="NumberForm[count]">',
                null,
            ],
        ];
    }

    /**
     * @dataProvider dataMin
     */
    public function testMin(string $expected, $value): void
    {
        $result = Number::widget()
            ->formAttribute(new NumberForm(), 'count')
            ->hideLabel()
            ->useContainer(false)
            ->min($value)
            ->render();

        $this->assertSame($expected, $result);
    }

    public function dataStep(): array
    {
        return [
            'int' => [
                '<input type="number" id="numberform-count" name="NumberForm[count]" step="1">',
                1,
            ],
            'string' => [
                '<input type="number" id="numberform-count" name="NumberForm[count]" step="2">',
                '2',
            ],
            'float' => [
                '<input type="number" id="numberform-count" name="NumberForm[count]" step="5.9">',
                '5.9',
            ],
            'Stringable' => [
                '<input type="number" id="numberform-count" name="NumberForm[count]" step="7">',
                new StringableObject('7'),
            ],
            'null' => [
                '<input type="number" id="numberform-count" name="NumberForm[count]">',
                null,
            ],
        ];
    }

    /**
     * @dataProvider dataStep
     */
    public function testStep(string $expected, $value): void
    {
        $result = Number::widget()
            ->formAttribute(new NumberForm(), 'count')
            ->hideLabel()
            ->useContainer(false)
            ->step($value)
            ->render();

        $this->assertSame($expected, $result);
    }

    public function testReadonly(): void
    {
        $result = Number::widget()
            ->formAttribute(new NumberForm(), 'count')
            ->readonly()
            ->render();

        $expected = <<<HTML
            <div>
            <label for="numberform-count">Count</label>
            <input type="number" id="numberform-count" name="NumberForm[count]" readonly>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testRequired(): void
    {
        $result = Number::widget()
            ->formAttribute(new NumberForm(), 'count')
            ->required()
            ->render();

        $expected = <<<HTML
            <div>
            <label for="numberform-count">Count</label>
            <input type="number" id="numberform-count" name="NumberForm[count]" required>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testDisabled(): void
    {
        $result = Number::widget()
            ->formAttribute(new NumberForm(), 'count')
            ->disabled()
            ->render();

        $expected = <<<HTML
            <div>
            <label for="numberform-count">Count</label>
            <input type="number" id="numberform-count" name="NumberForm[count]" disabled>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testAriaDescribedBy(): void
    {
        $result = Number::widget()
            ->formAttribute(new NumberForm(), 'count')
            ->ariaDescribedBy('hint')
            ->render();

        $expected = <<<HTML
            <div>
            <label for="numberform-count">Count</label>
            <input type="number" id="numberform-count" name="NumberForm[count]" aria-describedby="hint">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testAriaLabel(): void
    {
        $result = Number::widget()
            ->formAttribute(new NumberForm(), 'count')
            ->ariaLabel('test')
            ->render();

        $expected = <<<HTML
            <div>
            <label for="numberform-count">Count</label>
            <input type="number" id="numberform-count" name="NumberForm[count]" aria-label="test">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testAutofocus(): void
    {
        $result = Number::widget()
            ->formAttribute(new NumberForm(), 'count')
            ->autofocus()
            ->render();

        $expected = <<<HTML
            <div>
            <label for="numberform-count">Count</label>
            <input type="number" id="numberform-count" name="NumberForm[count]" autofocus>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testTabIndex(): void
    {
        $result = Number::widget()
            ->formAttribute(new NumberForm(), 'count')
            ->tabIndex(5)
            ->render();

        $expected = <<<HTML
            <div>
            <label for="numberform-count">Count</label>
            <input type="number" id="numberform-count" name="NumberForm[count]" tabindex="5">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testInvalidValue(): void
    {
        $field = Number::widget()
            ->formAttribute(new NumberForm(), 'name');

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Number field requires a numeric or null value.');
        $field->render();
    }

    public function dataEnrichmentFromRules(): array
    {
        return [
            'required' => [
                '<input type="number" id="numberform-weight" name="NumberForm[weight]" required>',
                'weight',
            ],
            'number' => [
                '<input type="number" id="numberform-step" name="NumberForm[step]" min="5" max="95">',
                'step',
            ],
            'required-with-when' => [
                '<input type="number" id="numberform-requiredwhen" name="NumberForm[requiredWhen]">',
                'requiredWhen',
            ],
        ];
    }

    /**
     * @dataProvider dataEnrichmentFromRules
     */
    public function testEnrichmentFromRules(string $expected, string $attribute): void
    {
        $field = Number::widget()
            ->formAttribute(new NumberForm(), $attribute)
            ->hideLabel()
            ->enrichmentFromRules(true)
            ->useContainer(false);

        $this->assertSame($expected, $field->render());
    }

    public function testImmutability(): void
    {
        $field = Number::widget();

        $this->assertNotSame($field, $field->max(null));
        $this->assertNotSame($field, $field->min(null));
        $this->assertNotSame($field, $field->step(null));
        $this->assertNotSame($field, $field->readonly());
        $this->assertNotSame($field, $field->required());
        $this->assertNotSame($field, $field->disabled());
        $this->assertNotSame($field, $field->ariaDescribedBy(null));
        $this->assertNotSame($field, $field->ariaLabel(null));
        $this->assertNotSame($field, $field->autofocus());
        $this->assertNotSame($field, $field->tabIndex(null));
    }
}
