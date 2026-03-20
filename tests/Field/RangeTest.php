<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field\Range;
use Yiisoft\Form\PureField\InputData;
use Yiisoft\Form\Tests\Support\NullValidationRulesEnricher;
use Yiisoft\Form\Tests\Support\RequiredValidationRulesEnricher;
use Yiisoft\Form\Tests\Support\StringableObject;
use Yiisoft\Form\Tests\Support\StubValidationRulesEnricher;
use Yiisoft\Form\Theme\ThemeContainer;

final class RangeTest extends TestCase
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
                <label for="rangeform-volume">Volume level</label>
                <input name="RangeForm[volume]" value="23" min="1" max="100" id="rangeform-volume" type="range">
                </div>
                HTML,
                new InputData(
                    name: 'RangeForm[volume]',
                    value: 23,
                    label: 'Volume level',
                    id: 'rangeform-volume',
                ),
            ],
            'input-valid-class' => [
                <<<HTML
                <div>
                <input name="main" min="1" max="100" class="valid" type="range">
                </div>
                HTML,
                new InputData(name: 'main', validationErrors: []),
                ['inputValidClass' => 'valid', 'inputInvalidClass' => 'invalid'],
            ],
            'container-valid-class' => [
                <<<HTML
                <div class="valid">
                <input name="main" min="1" max="100" type="range">
                </div>
                HTML,
                new InputData(name: 'main', validationErrors: []),
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

        $result = Range::widget()
            ->inputData($inputData)
            ->min(1)
            ->max(100)
            ->render();

        $this->assertSame($expected, $result);
    }

    public function testAddOutputAttributes(): void
    {
        $result = Range::widget()
            ->name('volume')
            ->value(23)
            ->showOutput()
            ->addOutputAttributes(['class' => 'red'])
            ->addOutputAttributes(['id' => 'UID'])
            ->render();

        $expected = <<<HTML_WRAP
<div>
<input name="volume" value="23" type="range" oninput="document.getElementById(&quot;UID&quot;).innerHTML=this.value">
<span class="red" id="UID">23</span>
</div>
HTML_WRAP;

        $this->assertSame($expected, $result);
    }

    public function testOutputAttributes(): void
    {
        $result = Range::widget()
            ->name('volume')
            ->value(23)
            ->showOutput()
            ->outputAttributes(['class' => 'red'])
            ->outputAttributes(['id' => 'UID'])
            ->render();

        $expected = <<<HTML_WRAP
<div>
<input name="volume" value="23" type="range" oninput="document.getElementById(&quot;UID&quot;).innerHTML=this.value">
<span id="UID">23</span>
</div>
HTML_WRAP;

        $this->assertSame($expected, $result);
    }

    public function testWithOutput(): void
    {
        $result = Range::widget()
            ->name('volume')
            ->value(23)
            ->min(1)
            ->max(100)
            ->showOutput()
            ->outputAttributes(['id' => 'UID'])
            ->render();

        $expected = <<<HTML_WRAP
<div>
<input name="volume" value="23" min="1" max="100" type="range" oninput="document.getElementById(&quot;UID&quot;).innerHTML=this.value">
<span id="UID">23</span>
</div>
HTML_WRAP;

        $this->assertSame($expected, $result);
    }

    public function testCustomOutputTag(): void
    {
        $result = Range::widget()
            ->name('volume')
            ->value(23)
            ->showOutput()
            ->outputTag('div')
            ->outputAttributes(['id' => 'UID'])
            ->render();

        $expected = <<<HTML_WRAP
<div>
<input name="volume" value="23" type="range" oninput="document.getElementById(&quot;UID&quot;).innerHTML=this.value">
<div id="UID">23</div>
</div>
HTML_WRAP;

        $this->assertSame($expected, $result);
    }

    public function testEmptyOutputTag(): void
    {
        $field = Range::widget();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The output tag name it cannot be empty value.');
        $field->outputTag('');
    }

    public static function dataMax(): array
    {
        return [
            'int' => [
                '<input name="count" max="42" type="range">',
                42,
            ],
            'string' => [
                '<input name="count" max="53" type="range">',
                '53',
            ],
            'float' => [
                '<input name="count" max="5.9" type="range">',
                '5.9',
            ],
            'Stringable' => [
                '<input name="count" max="7" type="range">',
                new StringableObject('7'),
            ],
            'null' => [
                '<input name="count" type="range">',
                null,
            ],
        ];
    }

    #[DataProvider('dataMax')]
    public function testMax(string $expected, $value): void
    {
        $result = Range::widget()
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
                '<input name="count" min="42" type="range">',
                42,
            ],
            'string' => [
                '<input name="count" min="53" type="range">',
                '53',
            ],
            'float' => [
                '<input name="count" min="5.9" type="range">',
                '5.9',
            ],
            'Stringable' => [
                '<input name="count" min="7" type="range">',
                new StringableObject('7'),
            ],
            'null' => [
                '<input name="count" type="range">',
                null,
            ],
        ];
    }

    #[DataProvider('dataMin')]
    public function testMin(string $expected, $value): void
    {
        $result = Range::widget()
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
                '<input name="count" step="42" type="range">',
                42,
            ],
            'string' => [
                '<input name="count" step="53" type="range">',
                '53',
            ],
            'float' => [
                '<input name="count" step="5.9" type="range">',
                '5.9',
            ],
            'Stringable' => [
                '<input name="count" step="7" type="range">',
                new StringableObject('7'),
            ],
            'null' => [
                '<input name="count" type="range">',
                null,
            ],
        ];
    }

    #[DataProvider('dataStep')]
    public function testStep(string $expected, $value): void
    {
        $result = Range::widget()
            ->name('count')
            ->hideLabel()
            ->useContainer(false)
            ->step($value)
            ->render();

        $this->assertSame($expected, $result);
    }

    public function testList(): void
    {
        $result = Range::widget()
            ->name('count')
            ->hideLabel()
            ->useContainer(false)
            ->list('TheList')
            ->render();

        $this->assertSame(
            '<input name="count" list="TheList" type="range">',
            $result,
        );
    }

    public function testDisabled(): void
    {
        $result = Range::widget()
            ->name('count')
            ->hideLabel()
            ->useContainer(false)
            ->disabled()
            ->render();

        $this->assertSame(
            '<input name="count" disabled type="range">',
            $result,
        );
    }

    public static function dataAriaDescribedBy(): array
    {
        return [
            'one element' => [
                ['hint'],
                '<input name="count" aria-describedby="hint" type="range">',
            ],
            'multiple elements' => [
                ['hint1', 'hint2'],
                '<input name="count" aria-describedby="hint1 hint2" type="range">',
            ],
            'null with other elements' => [
                ['hint1', null, 'hint2', null, 'hint3'],
                '<input name="count" aria-describedby="hint1 hint2 hint3" type="range">',
            ],
            'only null' => [
                [null, null],
                '<input name="count" type="range">',
            ],
            'empty string' => [
                [''],
                '<input name="count" aria-describedby type="range">',
            ],
        ];
    }

    #[DataProvider('dataAriaDescribedBy')]
    public function testAriaDescribedBy(array $ariaDescribedBy, string $expectedHtml): void
    {
        $actualHtml = Range::widget()
            ->name('count')
            ->hideLabel()
            ->useContainer(false)
            ->ariaDescribedBy(...$ariaDescribedBy)
            ->render();
        $this->assertSame($expectedHtml, $actualHtml);
    }

    public function testAriaLabel(): void
    {
        $result = Range::widget()
            ->name('count')
            ->hideLabel()
            ->useContainer(false)
            ->ariaLabel('test')
            ->render();

        $this->assertSame(
            '<input name="count" aria-label="test" type="range">',
            $result,
        );
    }

    public function testAutofocus(): void
    {
        $result = Range::widget()
            ->name('count')
            ->hideLabel()
            ->useContainer(false)
            ->autofocus()
            ->render();

        $this->assertSame(
            '<input name="count" autofocus type="range">',
            $result,
        );
    }

    public function testTabIndex(): void
    {
        $result = Range::widget()
            ->name('count')
            ->hideLabel()
            ->useContainer(false)
            ->tabIndex(5)
            ->render();

        $this->assertSame(
            '<input name="count" tabindex="5" type="range">',
            $result,
        );
    }

    public function testInvalidValue(): void
    {
        $field = Range::widget()->value([]);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Range field requires a string, numeric or null value.');
        $field->render();
    }

    public function testEnrichFromValidationRulesEnabled(): void
    {
        $html = Range::widget()
            ->enrichFromValidationRules()
            ->validationRulesEnricher(
                new StubValidationRulesEnricher([
                    'inputAttributes' => ['data-test' => 1],
                ]),
            )
            ->render();

        $expected = <<<HTML
            <div>
            <input data-test="1" type="range">
            </div>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testEnrichFromValidationRulesEnabledWithProvidedRules(): void
    {
        $actualHtml = Range::widget()
            ->enrichFromValidationRules()
            ->validationRulesEnricher(new RequiredValidationRulesEnricher())
            ->inputData(new InputData(validationRules: [['required']]))
            ->render();
        $expectedHtml = <<<HTML
            <div>
            <input required type="range">
            </div>
            HTML;

        $this->assertSame($expectedHtml, $actualHtml);
    }

    public function testEnrichFromValidationRulesEnabledWithNullProcessResult(): void
    {
        $actualHtml = Range::widget()
            ->enrichFromValidationRules()
            ->validationRulesEnricher(new NullValidationRulesEnricher())
            ->render();
        $expectedHtml = <<<HTML
            <div>
            <input type="range">
            </div>
            HTML;

        $this->assertSame($expectedHtml, $actualHtml);
    }

    public function testEnrichFromValidationRulesEnabledWithoutEnricher(): void
    {
        $actualHtml = Range::widget()
            ->enrichFromValidationRules()
            ->render();
        $expectedHtml = <<<HTML
            <div>
            <input type="range">
            </div>
            HTML;

        $this->assertSame($expectedHtml, $actualHtml);
    }

    public function testEnrichFromValidationRulesDisabled(): void
    {
        $html = Range::widget()
            ->validationRulesEnricher(
                new StubValidationRulesEnricher([
                    'inputAttributes' => ['data-test' => 1],
                ]),
            )
            ->render();

        $expected = <<<HTML
            <div>
            <input type="range">
            </div>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testInvalidClassesWithCustomError(): void
    {
        $inputData = new InputData('company', '');

        $result = Range::widget()
            ->invalidClass('invalidWrap')
            ->inputValidClass('validWrap')
            ->inputInvalidClass('invalid')
            ->inputValidClass('valid')
            ->inputData($inputData)
            ->error('Value cannot be blank.')
            ->render();

        $expected = <<<HTML
            <div class="invalidWrap">
            <input name="company" value class="invalid" type="range">
            <div>Value cannot be blank.</div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testImmutability(): void
    {
        $field = Range::widget();

        $this->assertNotSame($field, $field->addOutputAttributes([]));
        $this->assertNotSame($field, $field->outputAttributes([]));
        $this->assertNotSame($field, $field->outputTag('div'));
        $this->assertNotSame($field, $field->showOutput());
        $this->assertNotSame($field, $field->tabIndex(null));
        $this->assertNotSame($field, $field->autofocus());
        $this->assertNotSame($field, $field->ariaLabel(null));
        $this->assertNotSame($field, $field->ariaDescribedBy(null));
        $this->assertNotSame($field, $field->disabled());
        $this->assertNotSame($field, $field->list(null));
        $this->assertNotSame($field, $field->step(null));
        $this->assertNotSame($field, $field->min(null));
        $this->assertNotSame($field, $field->max(null));
        $this->assertNotSame($field, $field->enrichFromValidationRules());
        $this->assertNotSame($field, $field->validationRulesEnricher(null));
    }
}
