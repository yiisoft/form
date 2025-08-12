<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field\Color;
use Yiisoft\Form\PureField\InputData;
use Yiisoft\Form\Tests\Support\NullValidationRulesEnricher;
use Yiisoft\Form\Tests\Support\RequiredValidationRulesEnricher;
use Yiisoft\Form\Tests\Support\StubValidationRulesEnricher;
use Yiisoft\Form\Theme\ThemeContainer;

final class ColorTest extends TestCase
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
                <label for="colorform-bgcolor">Background Color</label>
                <input type="color" id="colorform-bgcolor" name="ColorForm[bgcolor]">
                <div>Select a background color.</div>
                </div>
                HTML,
                new InputData(
                    name: 'ColorForm[bgcolor]',
                    value: null,
                    label: 'Background Color',
                    hint: 'Select a background color.',
                    id: 'colorform-bgcolor',
                ),
            ],
            'input-valid-class' => [
                <<<HTML
                <div>
                <input type="color" class="valid" name="color">
                </div>
                HTML,
                new InputData(
                    name: 'color',
                    value: null,
                    validationErrors: [],
                ),
                ['inputValidClass' => 'valid', 'inputInvalidClass' => 'invalid'],
            ],
            'container-valid-class' => [
                <<<HTML
                <div class="valid">
                <input type="color" name="color">
                </div>
                HTML,
                new InputData(
                    name: 'color',
                    value: null,
                    validationErrors: [],
                ),
                ['validClass' => 'valid', 'invalidClass' => 'invalid'],
            ],
            'value' => [
                <<<HTML
                <div>
                <input type="color" name="color" value="#ff0000">
                </div>
                HTML,
                new InputData(
                    name: 'color',
                    value: '#ff0000',
                ),
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

        $result = Color::widget()->inputData($inputData)->render();

        $this->assertSame($expected, $result);
    }

    public function testReadonly(): void
    {
        $result = Color::widget()
            ->name('test')
            ->readonly()
            ->hideLabel()
            ->render();

        $expected = <<<HTML
            <div>
            <input type="color" name="test" readonly>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testRequired(): void
    {
        $result = Color::widget()
            ->name('test')
            ->required()
            ->hideLabel()
            ->render();

        $expected = <<<HTML
            <div>
            <input type="color" name="test" required>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testDisabled(): void
    {
        $result = Color::widget()
            ->name('test')
            ->disabled()
            ->hideLabel()
            ->render();

        $expected = <<<HTML
            <div>
            <input type="color" name="test" disabled>
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
                <input type="color" name="test" aria-describedby="hint">
                </div>
                HTML,
            ],
            'multiple elements' => [
                ['hint1', 'hint2'],
                <<<HTML
                <div>
                <input type="color" name="test" aria-describedby="hint1 hint2">
                </div>
                HTML,
            ],
            'null with other elements' => [
                ['hint1', null, 'hint2', null, 'hint3'],
                <<<HTML
                <div>
                <input type="color" name="test" aria-describedby="hint1 hint2 hint3">
                </div>
                HTML,
            ],
            'only null' => [
                [null, null],
                <<<HTML
                <div>
                <input type="color" name="test">
                </div>
                HTML,
            ],
            'empty string' => [
                [''],
                <<<HTML
                <div>
                <input type="color" name="test" aria-describedby>
                </div>
                HTML,
            ],
        ];
    }

    #[DataProvider('dataAriaDescribedBy')]
    public function testAriaDescribedBy(array $ariaDescribedBy, string $expectedHtml): void
    {
        $actualHtml = Color::widget()
            ->name('test')
            ->ariaDescribedBy(...$ariaDescribedBy)
            ->hideLabel()
            ->render();

        $this->assertSame($expectedHtml, $actualHtml);
    }

    public function testAriaLabel(): void
    {
        $result = Color::widget()
            ->name('test')
            ->ariaLabel('test')
            ->hideLabel()
            ->render();

        $expected = <<<HTML
            <div>
            <input type="color" name="test" aria-label="test">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testAutofocus(): void
    {
        $result = Color::widget()
            ->name('test')
            ->autofocus()
            ->hideLabel()
            ->render();

        $expected = <<<HTML
            <div>
            <input type="color" name="test" autofocus>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testTabIndex(): void
    {
        $result = Color::widget()
            ->name('test')
            ->tabIndex(5)
            ->hideLabel()
            ->render();

        $expected = <<<HTML
            <div>
            <input type="color" name="test" tabindex="5">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testValue(): void
    {
        $result = Color::widget()
            ->name('test')
            ->value('#123456')
            ->hideLabel()
            ->render();

        $expected = <<<HTML
            <div>
            <input type="color" name="test" value="#123456">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testValueNull(): void
    {
        $result = Color::widget()
            ->name('test')
            ->value(null)
            ->hideLabel()
            ->render();

        $expected = <<<HTML
            <div>
            <input type="color" name="test">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testInvalidValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Color field requires a string or null value.');
        Color::widget()->name('test')->value(123)->render();
    }

    public function testEnrichFromValidationRules(): void
    {
        $result = Color::widget()
            ->enrichFromValidationRules()
            ->validationRulesEnricher(new RequiredValidationRulesEnricher())
            ->inputData(new InputData('color', validationRules: [['required']]))
            ->hideLabel()
            ->render();

        $expected = <<<HTML
            <div>
            <input type="color" name="color" required>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testEnrichFromValidationRulesDisabled(): void
    {
        $result = Color::widget()
            ->validationRulesEnricher(new RequiredValidationRulesEnricher())
            ->inputData(new InputData('color', validationRules: [['required']]))
            ->hideLabel()
            ->render();

        $expected = <<<HTML
            <div>
            <input type="color" name="color">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testEnrichFromValidationRulesWithNullProcessResult(): void
    {
        $result = Color::widget()
            ->enrichFromValidationRules()
            ->validationRulesEnricher(new NullValidationRulesEnricher())
            ->inputData(new InputData('color'))
            ->hideLabel()
            ->render();

        $expected = <<<HTML
            <div>
            <input type="color" name="color">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testEnrichmentInputAttributes(): void
    {
        $result = Color::widget()
            ->enrichFromValidationRules()
            ->validationRulesEnricher(
                new StubValidationRulesEnricher(['inputAttributes' => ['data-test' => 1]])
            )
            ->inputData(new InputData('color'))
            ->hideLabel()
            ->render();

        $expected = <<<HTML
            <div>
            <input type="color" name="color" data-test="1">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testInvalidClassesFromContainer(): void
    {
        $inputData = new InputData('color', validationErrors: ['Value cannot be blank.']);

        $result = Color::widget()
            ->validClass('valid')
            ->invalidClass('invalid')
            ->inputData($inputData)
            ->hideLabel()
            ->render();

        $expected = <<<HTML
            <div class="invalid">
            <input type="color" name="color">
            <div>Value cannot be blank.</div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testValidClassesFromContainer(): void
    {
        $inputData = new InputData('color', validationErrors: []);

        $result = Color::widget()
            ->validClass('valid')
            ->invalidClass('invalid')
            ->inputData($inputData)
            ->hideLabel()
            ->render();

        $expected = <<<HTML
            <div class="valid">
            <input type="color" name="color">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testInvalidClassesFromInput(): void
    {
        $inputData = new InputData('color', validationErrors: ['Value cannot be blank.']);

        $result = Color::widget()
            ->inputValidClass('valid')
            ->inputInvalidClass('invalid')
            ->inputData($inputData)
            ->hideLabel()
            ->render();

        $expected = <<<HTML
            <div>
            <input type="color" class="invalid" name="color">
            <div>Value cannot be blank.</div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testValidClassesFromInput(): void
    {
        $inputData = new InputData('color', validationErrors: []);

        $result = Color::widget()
            ->inputValidClass('valid')
            ->inputInvalidClass('invalid')
            ->inputData($inputData)
            ->hideLabel()
            ->render();

        $expected = <<<HTML
            <div>
            <input type="color" class="valid" name="color">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }
}
