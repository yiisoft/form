<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field\Number;
use Yiisoft\Form\PureField\InputData;
use Yiisoft\Form\Tests\Support\NullValidationRulesEnricher;
use Yiisoft\Form\Tests\Support\RequiredValidationRulesEnricher;
use Yiisoft\Form\Tests\Support\StringableObject;
use Yiisoft\Form\Tests\Support\StubValidationRulesEnricher;
use Yiisoft\Form\Theme\ThemeContainer;

final class NumberTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        ThemeContainer::initialize();
    }

    public static function dataBase(): array
    {
        return [
            'base' => [
                <<<HTML
                <div>
                <label for="numberform-age">Your age</label>
                <input type="number" id="numberform-age" name="NumberForm[age]" value="42">
                <div>Full years.</div>
                </div>
                HTML,
                new InputData(
                    name: 'NumberForm[age]',
                    value: 42,
                    hint: 'Full years.',
                    label: 'Your age',
                    id: 'numberform-age',
                ),
            ],
            'input-valid-class' => [
                <<<HTML
                <div>
                <input type="number" class="valid" name="main" value="1">
                </div>
                HTML,
                new InputData(name: 'main', value: 1, validationErrors: []),
                ['inputValidClass' => 'valid', 'inputInvalidClass' => 'invalid'],
            ],
            'container-valid-class' => [
                <<<HTML
                <div class="valid">
                <input type="number" name="main" value="1">
                </div>
                HTML,
                new InputData(name: 'main', value: 1, validationErrors: []),
                ['validClass' => 'valid', 'invalidClass' => 'invalid'],
            ],
            'placeholder' => [
                <<<HTML
                <div>
                <input type="number" name="main" value="1" placeholder="test">
                </div>
                HTML,
                new InputData(name: 'main', value: 1, placeholder: 'test'),
            ],
        ];
    }

    #[DataProvider('dataBase')]
    public function testBase(string $expected, InputData $inputData, array $theme = []): void
    {
        ThemeContainer::initialize(
            configs: ['default' => $theme],
            defaultConfig: 'default',
        );

        $result = Number::widget()
            ->inputData($inputData)
            ->render();

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

    public static function dataAriaDescribedBy(): array
    {
        return [
            'one element' => [
                ['hint'],
                <<<HTML
                <div>
                <input type="number" name="count" aria-describedby="hint">
                </div>
                HTML,
            ],
            'multiple elements' => [
                ['hint1', 'hint2'],
                <<<HTML
                <div>
                <input type="number" name="count" aria-describedby="hint1 hint2">
                </div>
                HTML,
            ],
            'null with other elements' => [
                ['hint1', null, 'hint2', null, 'hint3'],
                <<<HTML
                <div>
                <input type="number" name="count" aria-describedby="hint1 hint2 hint3">
                </div>
                HTML,
            ],
            'only null' => [
                [null, null],
                <<<HTML
                <div>
                <input type="number" name="count">
                </div>
                HTML,
            ],
            'empty string' => [
                [''],
                <<<HTML
                <div>
                <input type="number" name="count" aria-describedby>
                </div>
                HTML,
            ],
        ];
    }

    #[DataProvider('dataAriaDescribedBy')]
    public function testAriaDescribedBy(array $ariaDescribedBy, string $expectedHtml): void
    {
        $actualHtml = Number::widget()
            ->name('count')
            ->ariaDescribedBy(...$ariaDescribedBy)
            ->render();
        $this->assertSame($expectedHtml, $actualHtml);
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

    public static function dataValues(): array
    {
        return [
            [null, null],
            [' value', ''],
            [' value="0"', 0],
            [' value="0.5"', 0.5],
            [' value="1"', 1],
            [' value="42"', '42'],
            [' value="0.5"', '0.5'],
        ];
    }

    #[DataProvider('dataValues')]
    public function testValues(?string $expected, mixed $value): void
    {
        $result = Number::widget()
            ->name('test')
            ->value($value)
            ->render();

        $expectedHtml = <<<HTML
            <div>
            <input type="number" name="test"$expected>
            </div>
            HTML;

        $this->assertSame($expectedHtml, $result);
    }

    public function testInvalidValue(): void
    {
        $field = Number::widget()->value('hello');

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Number field requires a numeric, an empty string or null value.');
        $field->render();
    }

    public function testEnrichFromValidationRulesEnabled(): void
    {
        $html = Number::widget()
            ->enrichFromValidationRules()
            ->validationRulesEnricher(
                new StubValidationRulesEnricher([
                    'inputAttributes' => ['data-test' => 1],
                ]),
            )
            ->render();

        $expected = <<<HTML
            <div>
            <input type="number" data-test="1">
            </div>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testEnrichFromValidationRulesEnabledWithProvidedRules(): void
    {
        $actualHtml = Number::widget()
            ->enrichFromValidationRules()
            ->validationRulesEnricher(new RequiredValidationRulesEnricher())
            ->inputData(new InputData(validationRules: [['required']]))
            ->render();
        $expectedHtml = <<<HTML
            <div>
            <input type="number" required>
            </div>
            HTML;

        $this->assertSame($expectedHtml, $actualHtml);
    }

    public function testEnrichFromValidationRulesEnabledWithNullProcessResult(): void
    {
        $actualHtml = Number::widget()
            ->enrichFromValidationRules()
            ->validationRulesEnricher(new NullValidationRulesEnricher())
            ->render();
        $expectedHtml = <<<HTML
            <div>
            <input type="number">
            </div>
            HTML;

        $this->assertSame($expectedHtml, $actualHtml);
    }

    public function testEnrichFromValidationRulesEnabledWithoutEnricher(): void
    {
        $actualHtml = Number::widget()
            ->enrichFromValidationRules()
            ->render();
        $expectedHtml = <<<HTML
            <div>
            <input type="number">
            </div>
            HTML;

        $this->assertSame($expectedHtml, $actualHtml);
    }

    public function testEnrichFromValidationRulesDisabled(): void
    {
        $html = Number::widget()
            ->validationRulesEnricher(
                new StubValidationRulesEnricher([
                    'inputAttributes' => ['data-test' => 1],
                ]),
            )
            ->render();

        $expected = <<<HTML
            <div>
            <input type="number">
            </div>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testInvalidClassesWithCustomError(): void
    {
        $inputData = new InputData('company');

        $result = Number::widget()
            ->invalidClass('invalidWrap')
            ->inputValidClass('validWrap')
            ->inputInvalidClass('invalid')
            ->inputValidClass('valid')
            ->inputData($inputData)
            ->error('Value cannot be blank.')
            ->render();

        $expected = <<<HTML
            <div class="invalidWrap">
            <input type="number" class="invalid" name="company">
            <div>Value cannot be blank.</div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
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
        $this->assertNotSame($field, $field->enrichFromValidationRules());
        $this->assertNotSame($field, $field->validationRulesEnricher(null));
    }
}
