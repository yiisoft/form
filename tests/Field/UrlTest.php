<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field\Url;
use Yiisoft\Form\PureField\InputData;
use Yiisoft\Form\Tests\Support\NullValidationRulesEnricher;
use Yiisoft\Form\Tests\Support\RequiredValidationRulesEnricher;
use Yiisoft\Form\Tests\Support\StubValidationRulesEnricher;
use Yiisoft\Form\Theme\ThemeContainer;

final class UrlTest extends TestCase
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
                <label for="urlform-site">Your site</label>
                <input type="url" id="urlform-site" name="UrlForm[site]" value>
                <div>Enter your site URL.</div>
                </div>
                HTML,
                new InputData(
                    name: 'UrlForm[site]',
                    value: '',
                    label: 'Your site',
                    hint: 'Enter your site URL.',
                    id: 'urlform-site',
                ),
            ],
            'input-valid-class' => [
                <<<HTML
                <div>
                <input type="url" class="valid" name="site" value>
                </div>
                HTML,
                new InputData(
                    name: 'site',
                    value: '',
                    validationErrors: [],
                ),
                ['inputValidClass' => 'valid', 'inputInvalidClass' => 'invalid'],
            ],
            'container-valid-class' => [
                <<<HTML
                <div class="valid">
                <input type="url" name="site" value>
                </div>
                HTML,
                new InputData(
                    name: 'site',
                    value: '',
                    validationErrors: [],
                ),
                ['validClass' => 'valid', 'invalidClass' => 'invalid'],
            ],
            'placeholder' => [
                <<<HTML
                <div>
                <input type="url" name="site" value placeholder="test">
                </div>
                HTML,
                new InputData(
                    name: 'site',
                    value: '',
                    placeholder: 'test'
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

        $result = Url::widget()->inputData($inputData)->render();

        $this->assertSame($expected, $result);
    }

    public function testMaxlength(): void
    {
        $result = Url::widget()
            ->name('test')
            ->maxlength(95)
            ->hideLabel()
            ->render();

        $expected = <<<HTML
            <div>
            <input type="url" name="test" maxlength="95">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testMinlength(): void
    {
        $result = Url::widget()
            ->name('test')
            ->minlength(3)
            ->hideLabel()
            ->render();

        $expected = <<<HTML
            <div>
            <input type="url" name="test" minlength="3">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testPattern(): void
    {
        $result = Url::widget()
            ->name('test')
            ->pattern('\w+')
            ->hideLabel()
            ->render();

        $expected = <<<HTML
            <div>
            <input type="url" name="test" pattern="\w+">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testReadonly(): void
    {
        $result = Url::widget()
            ->name('test')
            ->readonly()
            ->hideLabel()
            ->render();

        $expected = <<<HTML
            <div>
            <input type="url" name="test" readonly>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testRequired(): void
    {
        $result = Url::widget()
            ->name('test')
            ->required()
            ->hideLabel()
            ->render();

        $expected = <<<HTML
            <div>
            <input type="url" name="test" required>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testDisabled(): void
    {
        $result = Url::widget()
            ->name('test')
            ->disabled()
            ->hideLabel()
            ->render();

        $expected = <<<HTML
            <div>
            <input type="url" name="test" disabled>
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
                <input type="url" name="test" aria-describedby="hint">
                </div>
                HTML,
            ],
            'multiple elements' => [
                ['hint1', 'hint2'],
                <<<HTML
                <div>
                <input type="url" name="test" aria-describedby="hint1 hint2">
                </div>
                HTML,
            ],
            'null with other elements' => [
                ['hint1', null, 'hint2', null, 'hint3'],
                <<<HTML
                <div>
                <input type="url" name="test" aria-describedby="hint1 hint2 hint3">
                </div>
                HTML,
            ],
            'only null' => [
                [null, null],
                <<<HTML
                <div>
                <input type="url" name="test">
                </div>
                HTML,
            ],
            'empty string' => [
                [''],
                <<<HTML
                <div>
                <input type="url" name="test" aria-describedby>
                </div>
                HTML,
            ],
        ];
    }

    #[DataProvider('dataAriaDescribedBy')]
    public function testAriaDescribedBy(array $ariaDescribedBy, string $expectedHtml): void
    {
        $actualHtml = Url::widget()
            ->name('test')
            ->ariaDescribedBy(...$ariaDescribedBy)
            ->hideLabel()
            ->render();
        $this->assertSame($expectedHtml, $actualHtml);
    }

    public function testAriaLabel(): void
    {
        $result = Url::widget()
            ->name('test')
            ->ariaLabel('test')
            ->hideLabel()
            ->render();

        $expected = <<<HTML
            <div>
            <input type="url" name="test" aria-label="test">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testAutofocus(): void
    {
        $result = Url::widget()
            ->name('test')
            ->autofocus()
            ->hideLabel()
            ->render();

        $expected = <<<HTML
            <div>
            <input type="url" name="test" autofocus>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testTabIndex(): void
    {
        $result = Url::widget()
            ->name('test')
            ->tabIndex(5)
            ->hideLabel()
            ->render();

        $expected = <<<HTML
            <div>
            <input type="url" name="test" tabindex="5">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testSize(): void
    {
        $result = Url::widget()
            ->name('test')
            ->size(99)
            ->hideLabel()
            ->render();

        $expected = <<<HTML
            <div>
            <input type="url" name="test" size="99">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testInvalidValue(): void
    {
        $widget = Url::widget()->value(42);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('URL field requires a string or null value.');
        $widget->render();
    }

    public function testEnrichFromValidationRulesEnabled(): void
    {
        $html = Url::widget()
            ->enrichFromValidationRules()
            ->validationRulesEnricher(
                new StubValidationRulesEnricher([
                    'inputAttributes' => ['data-test' => 1],
                ])
            )
            ->render();

        $expected = <<<HTML
            <div>
            <input type="url" data-test="1">
            </div>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testEnrichFromValidationRulesEnabledWithProvidedRules(): void
    {
        $actualHtml = Url::widget()
            ->enrichFromValidationRules()
            ->validationRulesEnricher(new RequiredValidationRulesEnricher())
            ->inputData(new InputData(validationRules: [['required']]))
            ->render();
        $expectedHtml = <<<HTML
            <div>
            <input type="url" required>
            </div>
            HTML;

        $this->assertSame($expectedHtml, $actualHtml);
    }

    public function testEnrichFromValidationRulesEnabledWithNullProcessResult(): void
    {
        $actualHtml = Url::widget()
            ->enrichFromValidationRules()
            ->validationRulesEnricher(new NullValidationRulesEnricher())
            ->render();
        $expectedHtml = <<<HTML
            <div>
            <input type="url">
            </div>
            HTML;

        $this->assertSame($expectedHtml, $actualHtml);
    }

    public function testEnrichFromValidationRulesEnabledWithoutEnricher(): void
    {
        $actualHtml = Url::widget()
            ->enrichFromValidationRules()
            ->render();
        $expectedHtml = <<<HTML
            <div>
            <input type="url">
            </div>
            HTML;

        $this->assertSame($expectedHtml, $actualHtml);
    }

    public function testEnrichFromValidationRulesDisabled(): void
    {
        $html = Url::widget()
            ->validationRulesEnricher(
                new StubValidationRulesEnricher([
                    'inputAttributes' => ['data-test' => 1],
                ])
            )
            ->render();

        $expected = <<<HTML
            <div>
            <input type="url">
            </div>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testInvalidClassesWithCustomError(): void
    {
        $inputData = new InputData('company', '');

        $result = Url::widget()
            ->invalidClass('invalidWrap')
            ->inputValidClass('validWrap')
            ->inputInvalidClass('invalid')
            ->inputValidClass('valid')
            ->inputData($inputData)
            ->error('Value cannot be blank.')
            ->render();

        $expected = <<<HTML
            <div class="invalidWrap">
            <input type="url" class="invalid" name="company" value>
            <div>Value cannot be blank.</div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testImmutability(): void
    {
        $field = Url::widget();

        $this->assertNotSame($field, $field->maxlength(null));
        $this->assertNotSame($field, $field->minlength(null));
        $this->assertNotSame($field, $field->pattern(null));
        $this->assertNotSame($field, $field->readonly());
        $this->assertNotSame($field, $field->required());
        $this->assertNotSame($field, $field->disabled());
        $this->assertNotSame($field, $field->ariaDescribedBy(null));
        $this->assertNotSame($field, $field->ariaLabel(null));
        $this->assertNotSame($field, $field->autofocus());
        $this->assertNotSame($field, $field->tabIndex(null));
        $this->assertNotSame($field, $field->size(null));
        $this->assertNotSame($field, $field->enrichFromValidationRules());
        $this->assertNotSame($field, $field->validationRulesEnricher(null));
    }
}
