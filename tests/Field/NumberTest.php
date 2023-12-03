<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field\Base\InputData\PureInputData;
use Yiisoft\Form\Field\Number;
use Yiisoft\Form\Tests\Support\StringableObject;
use Yiisoft\Form\Tests\Support\StubValidationRulesEnricher;
use Yiisoft\Form\ThemeContainer;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class NumberTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer());
        ThemeContainer::initialize();
    }

    public function testBase(): void
    {
        $inputData = new PureInputData(
            name: 'NumberForm[age]',
            value: 42,
            hint: 'Full years.',
            label: 'Your age',
            id: 'numberform-age',
        );

        $result = Number::widget()
            ->inputData($inputData)
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

    public static function dataMax(): array
    {
        return [
            'int' => [
                '<input type="number" name="count" max="42">',
                42,
            ],
            'string' => [
                '<input type="number" name="count" max="53">',
                '53',
            ],
            'float' => [
                '<input type="number" name="count" max="5.9">',
                '5.9',
            ],
            'Stringable' => [
                '<input type="number" name="count" max="7">',
                new StringableObject('7'),
            ],
            'null' => [
                '<input type="number" name="count">',
                null,
            ],
        ];
    }

    #[DataProvider('dataMax')]
    public function testMax(string $expected, $value): void
    {
        $result = Number::widget()
            ->name('count')
            ->hideLabel()
            ->useContainer(false)
            ->max($value)
            ->render();

        $this->assertSame($expected, $result);
    }

    public static function dataMin(): array
    {
        return [
            'int' => [
                '<input type="number" name="count" min="42">',
                42,
            ],
            'string' => [
                '<input type="number" name="count" min="53">',
                '53',
            ],
            'float' => [
                '<input type="number" name="count" min="5.9">',
                '5.9',
            ],
            'Stringable' => [
                '<input type="number" name="count" min="7">',
                new StringableObject('7'),
            ],
            'null' => [
                '<input type="number" name="count">',
                null,
            ],
        ];
    }

    #[DataProvider('dataMin')]
    public function testMin(string $expected, $value): void
    {
        $result = Number::widget()
            ->name('count')
            ->hideLabel()
            ->useContainer(false)
            ->min($value)
            ->render();

        $this->assertSame($expected, $result);
    }

    public static function dataStep(): array
    {
        return [
            'int' => [
                '<input type="number" name="count" step="1">',
                1,
            ],
            'string' => [
                '<input type="number" name="count" step="2">',
                '2',
            ],
            'float' => [
                '<input type="number" name="count" step="5.9">',
                '5.9',
            ],
            'Stringable' => [
                '<input type="number" name="count" step="7">',
                new StringableObject('7'),
            ],
            'null' => [
                '<input type="number" name="count">',
                null,
            ],
        ];
    }

    #[DataProvider('dataStep')]
    public function testStep(string $expected, $value): void
    {
        $result = Number::widget()
            ->name('count')
            ->hideLabel()
            ->useContainer(false)
            ->step($value)
            ->render();

        $this->assertSame($expected, $result);
    }

    public function testReadonly(): void
    {
        $result = Number::widget()
            ->name('count')
            ->readonly()
            ->render();

        $expected = <<<HTML
            <div>
            <input type="number" name="count" readonly>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testRequired(): void
    {
        $result = Number::widget()
            ->name('count')
            ->required()
            ->render();

        $expected = <<<HTML
            <div>
            <input type="number" name="count" required>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testDisabled(): void
    {
        $result = Number::widget()
            ->name('count')
            ->disabled()
            ->render();

        $expected = <<<HTML
            <div>
            <input type="number" name="count" disabled>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testAriaDescribedBy(): void
    {
        $result = Number::widget()
            ->name('count')
            ->ariaDescribedBy('hint')
            ->render();

        $expected = <<<HTML
            <div>
            <input type="number" name="count" aria-describedby="hint">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testAriaLabel(): void
    {
        $result = Number::widget()
            ->name('count')
            ->ariaLabel('test')
            ->render();

        $expected = <<<HTML
            <div>
            <input type="number" name="count" aria-label="test">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testAutofocus(): void
    {
        $result = Number::widget()
            ->name('count')
            ->autofocus()
            ->render();

        $expected = <<<HTML
            <div>
            <input type="number" name="count" autofocus>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testTabIndex(): void
    {
        $result = Number::widget()
            ->name('count')
            ->tabIndex(5)
            ->render();

        $expected = <<<HTML
            <div>
            <input type="number" name="count" tabindex="5">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testInvalidValue(): void
    {
        $field = Number::widget()->value('hello');

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Number field requires a numeric or null value.');
        $field->render();
    }

    public function testEnrichFromValidationRulesEnabled(): void
    {
        ThemeContainer::initialize(
            validationRulesEnricher: new StubValidationRulesEnricher([
                'inputAttributes' => ['data-test' => 1],
            ]),
        );

        $html = Number::widget()->enrichFromValidationRules()->render();

        $expected = <<<HTML
            <div>
            <input type="number" data-test="1">
            </div>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testEnrichFromValidationRulesDisabled(): void
    {
        ThemeContainer::initialize(
            validationRulesEnricher: new StubValidationRulesEnricher([
                'inputAttributes' => ['data-test' => 1],
            ]),
        );

        $html = Number::widget()->render();

        $expected = <<<HTML
            <div>
            <input type="number">
            </div>
            HTML;

        $this->assertSame($expected, $html);
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
