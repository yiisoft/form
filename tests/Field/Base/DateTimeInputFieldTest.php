<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field\Base;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\PureField\InputData;
use Yiisoft\Form\Tests\Support\NullValidationRulesEnricher;
use Yiisoft\Form\Tests\Support\RequiredValidationRulesEnricher;
use Yiisoft\Form\Tests\Support\StubDateTimeInputField;
use Yiisoft\Form\Tests\Support\StubValidationRulesEnricher;
use Yiisoft\Form\Theme\ThemeContainer;

final class DateTimeInputFieldTest extends TestCase
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
                <label for="dt-main">Main date</label>
                <input type="datetime" id="dt-main" name="dt" value>
                <div>Need correct date</div>
                </div>
                HTML,
                new InputData(
                    name: 'dt',
                    value: '',
                    label: 'Main date',
                    hint: 'Need correct date',
                    id: 'dt-main',
                ),
            ],
            'input-valid-class' => [
                <<<HTML
                <div>
                <input type="datetime" class="valid" name="main" value>
                </div>
                HTML,
                new InputData(name: 'main', value: '', validationErrors: []),
                ['inputValidClass' => 'valid', 'inputInvalidClass' => 'invalid'],
            ],
            'container-valid-class' => [
                <<<HTML
                <div class="valid">
                <input type="datetime" name="main" value>
                </div>
                HTML,
                new InputData(name: 'main', value: '', validationErrors: []),
                ['validClass' => 'valid', 'invalidClass' => 'invalid'],
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

        $result = StubDateTimeInputField::widget()->inputData($inputData)->render();

        $this->assertSame($expected, $result);
    }

    public function testMax(): void
    {
        $result = StubDateTimeInputField::widget()
            ->name('releaseDate')
            ->hideLabel()
            ->max('2030-12-31')
            ->render();

        $expected = <<<HTML
            <div>
            <input type="datetime" name="releaseDate" max="2030-12-31">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testMin(): void
    {
        $result = StubDateTimeInputField::widget()
            ->name('releaseDate')
            ->hideLabel()
            ->min('1999-01-01')
            ->render();

        $expected = <<<HTML
            <div>
            <input type="datetime" name="releaseDate" min="1999-01-01">
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
                <input type="datetime" name="releaseDate" aria-describedby="hint">
                </div>
                HTML,
            ],
            'multiple elements' => [
                ['hint1', 'hint2'],
                <<<HTML
                <div>
                <input type="datetime" name="releaseDate" aria-describedby="hint1 hint2">
                </div>
                HTML,
            ],
            'null with other elements' => [
                ['hint1', null, 'hint2', null, 'hint3'],
                <<<HTML
                <div>
                <input type="datetime" name="releaseDate" aria-describedby="hint1 hint2 hint3">
                </div>
                HTML,
            ],
            'only null' => [
                [null, null],
                <<<HTML
                <div>
                <input type="datetime" name="releaseDate">
                </div>
                HTML,
            ],
            'empty string' => [
                [''],
                <<<HTML
                <div>
                <input type="datetime" name="releaseDate" aria-describedby>
                </div>
                HTML,
            ],
        ];
    }

    #[DataProvider('dataAriaDescribedBy')]
    public function testAriaDescribedBy(array $ariaDescribedBy, string $expectedHtml): void
    {
        $actualHtml = StubDateTimeInputField::widget()
            ->name('releaseDate')
            ->hideLabel()
            ->ariaDescribedBy(...$ariaDescribedBy)
            ->render();
        $this->assertSame($expectedHtml, $actualHtml);
    }

    public function testAriaLabel(): void
    {
        $result = StubDateTimeInputField::widget()
            ->name('releaseDate')
            ->hideLabel()
            ->ariaLabel('test')
            ->render();

        $expected = <<<HTML
            <div>
            <input type="datetime" name="releaseDate" aria-label="test">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testAutofocus(): void
    {
        $result = StubDateTimeInputField::widget()
            ->name('releaseDate')
            ->hideLabel()
            ->autofocus()
            ->render();

        $expected = <<<HTML
            <div>
            <input type="datetime" name="releaseDate" autofocus>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testTabIndex(): void
    {
        $result = StubDateTimeInputField::widget()
            ->name('releaseDate')
            ->hideLabel()
            ->tabIndex(5)
            ->render();

        $expected = <<<HTML
            <div>
            <input type="datetime" name="releaseDate" tabindex="5">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testReadonly(): void
    {
        $result = StubDateTimeInputField::widget()
            ->name('releaseDate')
            ->hideLabel()
            ->readonly()
            ->render();

        $expected = <<<HTML
            <div>
            <input type="datetime" name="releaseDate" readonly>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testRequired(): void
    {
        $result = StubDateTimeInputField::widget()
            ->name('releaseDate')
            ->hideLabel()
            ->required()
            ->render();

        $expected = <<<HTML
            <div>
            <input type="datetime" name="releaseDate" required>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testDisabled(): void
    {
        $result = StubDateTimeInputField::widget()
            ->name('releaseDate')
            ->hideLabel()
            ->disabled()
            ->render();

        $expected = <<<HTML
            <div>
            <input type="datetime" name="releaseDate" disabled>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testInvalidValue(): void
    {
        $widget = StubDateTimeInputField::widget()->value(7);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('StubDateTimeInputField field requires a string or null value.');
        $widget->render();
    }

    public function testEnrichFromValidationRulesEnabled(): void
    {
        $html = StubDateTimeInputField::widget()
            ->enrichFromValidationRules()
            ->validationRulesEnricher(
                new StubValidationRulesEnricher([
                    'inputAttributes' => ['data-test' => 1],
                ])
            )
            ->render();

        $expected = <<<HTML
            <div>
            <input type="datetime" data-test="1">
            </div>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testEnrichFromValidationRulesEnabledWithProvidedRules(): void
    {
        $actualHtml = StubDateTimeInputField::widget()
            ->enrichFromValidationRules()
            ->validationRulesEnricher(new RequiredValidationRulesEnricher())
            ->inputData(new InputData(validationRules: [['required']]))
            ->render();
        $expectedHtml = <<<HTML
            <div>
            <input type="datetime" required>
            </div>
            HTML;

        $this->assertSame($expectedHtml, $actualHtml);
    }

    public function testEnrichFromValidationRulesEnabledWithNullProcessResult(): void
    {
        $actualHtml = StubDateTimeInputField::widget()
            ->enrichFromValidationRules()
            ->validationRulesEnricher(new NullValidationRulesEnricher())
            ->render();
        $expectedHtml = <<<HTML
            <div>
            <input type="datetime">
            </div>
            HTML;

        $this->assertSame($expectedHtml, $actualHtml);
    }

    public function testEnrichFromValidationRulesEnabledWithoutEnricher(): void
    {
        $actualHtml = StubDateTimeInputField::widget()
            ->enrichFromValidationRules()
            ->render();
        $expectedHtml = <<<HTML
            <div>
            <input type="datetime">
            </div>
            HTML;

        $this->assertSame($expectedHtml, $actualHtml);
    }

    public function testEnrichFromValidationRulesDisabled(): void
    {
        $html = StubDateTimeInputField::widget()
            ->validationRulesEnricher(
                new StubValidationRulesEnricher([
                    'inputAttributes' => ['data-test' => 1],
                ])
            )
            ->render();

        $expected = <<<HTML
            <div>
            <input type="datetime">
            </div>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testInvalidClassesWithCustomError(): void
    {
        $inputData = new InputData('company', '');

        $result = StubDateTimeInputField::widget()
            ->invalidClass('invalidWrap')
            ->inputValidClass('validWrap')
            ->inputInvalidClass('invalid')
            ->inputValidClass('valid')
            ->inputData($inputData)
            ->error('Value cannot be blank.')
            ->render();

        $expected = <<<HTML
            <div class="invalidWrap">
            <input type="datetime" class="invalid" name="company" value>
            <div>Value cannot be blank.</div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testImmutability(): void
    {
        $field = StubDateTimeInputField::widget();

        $this->assertNotSame($field, $field->max(null));
        $this->assertNotSame($field, $field->min(null));
        $this->assertNotSame($field, $field->ariaDescribedBy(null));
        $this->assertNotSame($field, $field->ariaLabel(null));
        $this->assertNotSame($field, $field->autofocus());
        $this->assertNotSame($field, $field->tabIndex(null));
        $this->assertNotSame($field, $field->readonly());
        $this->assertNotSame($field, $field->required());
        $this->assertNotSame($field, $field->disabled());
        $this->assertNotSame($field, $field->enrichFromValidationRules());
        $this->assertNotSame($field, $field->validationRulesEnricher(null));
    }
}
