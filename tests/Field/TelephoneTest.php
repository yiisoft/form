<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field\Telephone;
use Yiisoft\Form\PureField\InputData;
use Yiisoft\Form\Tests\Support\NullValidationRulesEnricher;
use Yiisoft\Form\Tests\Support\RequiredValidationRulesEnricher;
use Yiisoft\Form\Tests\Support\StubValidationRulesEnricher;
use Yiisoft\Form\Theme\ThemeContainer;

final class TelephoneTest extends TestCase
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
                <label for="telephoneform-number">Phone</label>
                <input type="tel" id="telephoneform-number" name="TelephoneForm[number]" value>
                <div>Enter your phone.</div>
                </div>
                HTML,
                new InputData(
                    name: 'TelephoneForm[number]',
                    value: '',
                    id: 'telephoneform-number',
                    label: 'Phone',
                    hint: 'Enter your phone.',
                ),
            ],
            'input-valid-class' => [
                <<<HTML
                <div>
                <input type="tel" class="valid" name="main" value>
                </div>
                HTML,
                new InputData(name: 'main', value: '', validationErrors: []),
                ['inputValidClass' => 'valid', 'inputInvalidClass' => 'invalid'],
            ],
            'container-valid-class' => [
                <<<HTML
                <div class="valid">
                <input type="tel" name="main" value>
                </div>
                HTML,
                new InputData(name: 'main', value: '', validationErrors: []),
                ['validClass' => 'valid', 'invalidClass' => 'invalid'],
            ],
            'placeholder' => [
                <<<HTML
                <div>
                <input type="tel" name="main" value placeholder="test">
                </div>
                HTML,
                new InputData(name: 'main', value: '', placeholder: 'test'),
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

        $result = Telephone::widget()->inputData($inputData)->render();

        $this->assertSame($expected, $result);
    }

    public function testMaxlength(): void
    {
        $result = Telephone::widget()
            ->name('phone')
            ->useContainer(false)
            ->hideLabel()
            ->maxlength(12)
            ->render();

        $this->assertSame(
            '<input type="tel" name="phone" maxlength="12">',
            $result
        );
    }

    public function testMinlength(): void
    {
        $result = Telephone::widget()
            ->name('phone')
            ->useContainer(false)
            ->hideLabel()
            ->minlength(7)
            ->render();

        $this->assertSame(
            '<input type="tel" name="phone" minlength="7">',
            $result
        );
    }

    public function testPattern(): void
    {
        $result = Telephone::widget()
            ->name('phone')
            ->useContainer(false)
            ->hideLabel()
            ->pattern('\d+')
            ->render();

        $this->assertSame(
            '<input type="tel" name="phone" pattern="\d+">',
            $result
        );
    }

    public function testReadonly(): void
    {
        $result = Telephone::widget()
            ->name('phone')
            ->useContainer(false)
            ->hideLabel()
            ->readonly()
            ->render();

        $this->assertSame(
            '<input type="tel" name="phone" readonly>',
            $result
        );
    }

    public function testRequired(): void
    {
        $result = Telephone::widget()
            ->name('phone')
            ->useContainer(false)
            ->hideLabel()
            ->required()
            ->render();

        $this->assertSame(
            '<input type="tel" name="phone" required>',
            $result
        );
    }

    public function testDisabled(): void
    {
        $result = Telephone::widget()
            ->name('phone')
            ->useContainer(false)
            ->hideLabel()
            ->disabled()
            ->render();

        $this->assertSame(
            '<input type="tel" name="phone" disabled>',
            $result
        );
    }

    public function testAriaDescribedBy(): void
    {
        $result = Telephone::widget()
            ->name('phone')
            ->useContainer(false)
            ->hideLabel()
            ->ariaDescribedBy('hint')
            ->render();

        $this->assertSame(
            '<input type="tel" name="phone" aria-describedby="hint">',
            $result
        );
    }

    public function testAriaLabel(): void
    {
        $result = Telephone::widget()
            ->name('phone')
            ->useContainer(false)
            ->hideLabel()
            ->ariaLabel('test')
            ->render();

        $this->assertSame(
            '<input type="tel" name="phone" aria-label="test">',
            $result
        );
    }

    public function testAutofocus(): void
    {
        $result = Telephone::widget()
            ->name('phone')
            ->useContainer(false)
            ->hideLabel()
            ->autofocus()
            ->render();

        $this->assertSame(
            '<input type="tel" name="phone" autofocus>',
            $result
        );
    }

    public function testTabIndex(): void
    {
        $result = Telephone::widget()
            ->name('phone')
            ->useContainer(false)
            ->hideLabel()
            ->tabIndex(5)
            ->render();

        $this->assertSame(
            '<input type="tel" name="phone" tabindex="5">',
            $result
        );
    }

    public function testSize(): void
    {
        $result = Telephone::widget()
            ->name('phone')
            ->useContainer(false)
            ->hideLabel()
            ->size(9)
            ->render();

        $this->assertSame(
            '<input type="tel" name="phone" size="9">',
            $result
        );
    }

    public function testInvalidValue(): void
    {
        $widget = Telephone::widget()->value(7);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Telephone field requires a string or null value.');
        $widget->render();
    }

    public function testEnrichFromValidationRulesEnabled(): void
    {
        $html = Telephone::widget()
            ->enrichFromValidationRules()
            ->validationRulesEnricher(
                new StubValidationRulesEnricher([
                    'inputAttributes' => ['data-test' => 1],
                ])
            )
            ->render();

        $expected = <<<HTML
            <div>
            <input type="tel" data-test="1">
            </div>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testEnrichFromValidationRulesEnabledWithProvidedRules(): void
    {
        $actualHtml = Telephone::widget()
            ->enrichFromValidationRules()
            ->validationRulesEnricher(new RequiredValidationRulesEnricher())
            ->inputData(new InputData(validationRules: [['required']]))
            ->render();
        $expectedHtml = <<<HTML
            <div>
            <input type="tel" required>
            </div>
            HTML;

        $this->assertSame($expectedHtml, $actualHtml);
    }

    public function testEnrichFromValidationRulesEnabledWithNullProcessResult(): void
    {
        $actualHtml = Telephone::widget()
            ->enrichFromValidationRules()
            ->validationRulesEnricher(new NullValidationRulesEnricher())
            ->render();
        $expectedHtml = <<<HTML
            <div>
            <input type="tel">
            </div>
            HTML;

        $this->assertSame($expectedHtml, $actualHtml);
    }

    public function testEnrichFromValidationRulesEnabledWithoutEnricher(): void
    {
        $actualHtml = Telephone::widget()
            ->enrichFromValidationRules()
            ->render();
        $expectedHtml = <<<HTML
            <div>
            <input type="tel">
            </div>
            HTML;

        $this->assertSame($expectedHtml, $actualHtml);
    }

    public function testEnrichFromValidationRulesDisabled(): void
    {
        $html = Telephone::widget()
            ->validationRulesEnricher(
                new StubValidationRulesEnricher([
                    'inputAttributes' => ['data-test' => 1],
                ])
            )
            ->render();

        $expected = <<<HTML
            <div>
            <input type="tel">
            </div>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testInvalidClassesWithCustomError(): void
    {
        $inputData = new InputData('company', '');

        $result = Telephone::widget()
            ->invalidClass('invalidWrap')
            ->inputValidClass('validWrap')
            ->inputInvalidClass('invalid')
            ->inputValidClass('valid')
            ->inputData($inputData)
            ->error('Value cannot be blank.')
            ->render();

        $expected = <<<HTML
            <div class="invalidWrap">
            <input type="tel" class="invalid" name="company" value>
            <div>Value cannot be blank.</div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testImmutability(): void
    {
        $field = Telephone::widget();

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
