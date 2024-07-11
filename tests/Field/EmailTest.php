<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field\Email;
use Yiisoft\Form\PureField\InputData;
use Yiisoft\Form\Tests\Support\NullValidationRulesEnricher;
use Yiisoft\Form\Tests\Support\RequiredValidationRulesEnricher;
use Yiisoft\Form\Tests\Support\StubValidationRulesEnricher;
use Yiisoft\Form\Theme\ThemeContainer;

final class EmailTest extends TestCase
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
                <label for="emailform-main">Main email</label>
                <input type="email" id="emailform-main" name="EmailForm[main]" value>
                <div>Email for notifications.</div>
                </div>
                HTML,
                new InputData(
                    name: 'EmailForm[main]',
                    value: '',
                    label: 'Main email',
                    hint: 'Email for notifications.',
                    id: 'emailform-main',
                ),
            ],
            'input-valid-class' => [
                <<<HTML
                <div>
                <input type="email" class="valid" name="main" value>
                </div>
                HTML,
                new InputData(name: 'main', value: '', validationErrors: []),
                ['inputValidClass' => 'valid', 'inputInvalidClass' => 'invalid'],
            ],
            'container-valid-class' => [
                <<<HTML
                <div class="valid">
                <input type="email" name="main" value>
                </div>
                HTML,
                new InputData(name: 'main', value: '', validationErrors: []),
                ['validClass' => 'valid', 'invalidClass' => 'invalid'],
            ],
            'placeholder' => [
                <<<HTML
                <div>
                <input type="email" name="main" value placeholder="test">
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

        $result = Email::widget()->inputData($inputData)->render();

        $this->assertSame($expected, $result);
    }

    public function testMaxlength(): void
    {
        $result = Email::widget()
            ->name('mainEmail')
            ->maxlength(99)
            ->render();

        $expected = <<<HTML
            <div>
            <input type="email" name="mainEmail" maxlength="99">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testMinlength(): void
    {
        $result = Email::widget()
            ->name('mainEmail')
            ->minlength(5)
            ->render();

        $expected = <<<HTML
            <div>
            <input type="email" name="mainEmail" minlength="5">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testMultiple(): void
    {
        $result = Email::widget()
            ->name('mainEmail')
            ->multiple()
            ->render();

        $expected = <<<HTML
            <div>
            <input type="email" name="mainEmail" multiple>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testPattern(): void
    {
        $result = Email::widget()
            ->name('mainEmail')
            ->pattern('\w+@\w+')
            ->render();

        $expected = <<<HTML
            <div>
            <input type="email" name="mainEmail" pattern="\w+@\w+">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testReadonly(): void
    {
        $result = Email::widget()
            ->name('mainEmail')
            ->readonly()
            ->render();

        $expected = <<<HTML
            <div>
            <input type="email" name="mainEmail" readonly>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testRequired(): void
    {
        $result = Email::widget()
            ->name('mainEmail')
            ->required()
            ->render();

        $expected = <<<HTML
            <div>
            <input type="email" name="mainEmail" required>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testSize(): void
    {
        $result = Email::widget()
            ->name('mainEmail')
            ->size(99)
            ->render();

        $expected = <<<HTML
            <div>
            <input type="email" name="mainEmail" size="99">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testDisabled(): void
    {
        $result = Email::widget()
            ->name('mainEmail')
            ->disabled()
            ->render();

        $expected = <<<HTML
            <div>
            <input type="email" name="mainEmail" disabled>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testAriaDescribedBy(): void
    {
        $result = Email::widget()
            ->name('mainEmail')
            ->ariaDescribedBy('hint')
            ->render();

        $expected = <<<HTML
            <div>
            <input type="email" name="mainEmail" aria-describedby="hint">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testAriaLabel(): void
    {
        $result = Email::widget()
            ->name('mainEmail')
            ->ariaLabel('test')
            ->render();

        $expected = <<<HTML
            <div>
            <input type="email" name="mainEmail" aria-label="test">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testAutofocus(): void
    {
        $result = Email::widget()
            ->name('mainEmail')
            ->autofocus()
            ->render();

        $expected = <<<HTML
            <div>
            <input type="email" name="mainEmail" autofocus>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testTabIndex(): void
    {
        $result = Email::widget()
            ->name('mainEmail')
            ->tabIndex(2)
            ->render();

        $expected = <<<HTML
            <div>
            <input type="email" name="mainEmail" tabindex="2">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testInvalidValue(): void
    {
        $field = Email::widget()->value(7);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Email field requires a string or null value.');
        $field->render();
    }

    public function testEnrichFromValidationRulesEnabled(): void
    {
        $html = Email::widget()
            ->enrichFromValidationRules()
            ->validationRulesEnricher(
                new StubValidationRulesEnricher([
                    'inputAttributes' => ['data-test' => 1],
                ])
            )
            ->render();

        $expected = <<<HTML
            <div>
            <input type="email" data-test="1">
            </div>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testEnrichFromValidationRulesEnabledWithProvidedRules(): void
    {
        $actualHtml = Email::widget()
            ->enrichFromValidationRules()
            ->validationRulesEnricher(new RequiredValidationRulesEnricher())
            ->inputData(new InputData(validationRules: [['required']]))
            ->render();
        $expectedHtml = <<<HTML
            <div>
            <input type="email" required>
            </div>
            HTML;

        $this->assertSame($expectedHtml, $actualHtml);
    }

    public function testEnrichFromValidationRulesEnabledWithNullProcessResult(): void
    {
        $actualHtml = Email::widget()
            ->enrichFromValidationRules()
            ->validationRulesEnricher(new NullValidationRulesEnricher())
            ->render();
        $expectedHtml = <<<HTML
            <div>
            <input type="email">
            </div>
            HTML;

        $this->assertSame($expectedHtml, $actualHtml);
    }

    public function testEnrichFromValidationRulesEnabledWithoutEnricher(): void
    {
        $actualHtml = Email::widget()
            ->enrichFromValidationRules()
            ->render();
        $expectedHtml = <<<HTML
            <div>
            <input type="email">
            </div>
            HTML;

        $this->assertSame($expectedHtml, $actualHtml);
    }

    public function testEnrichFromValidationRulesDisabled(): void
    {
        $html = Email::widget()
            ->validationRulesEnricher(
                new StubValidationRulesEnricher([
                    'inputAttributes' => ['data-test' => 1],
                ])
            )
            ->render();

        $expected = <<<HTML
            <div>
            <input type="email">
            </div>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testInvalidClassesWithCustomError(): void
    {
        $inputData = new InputData('company', '');

        $result = Email::widget()
            ->invalidClass('invalidWrap')
            ->inputValidClass('validWrap')
            ->inputInvalidClass('invalid')
            ->inputValidClass('valid')
            ->inputData($inputData)
            ->error('Value cannot be blank.')
            ->render();

        $expected = <<<HTML
            <div class="invalidWrap">
            <input type="email" class="invalid" name="company" value>
            <div>Value cannot be blank.</div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testImmutability(): void
    {
        $field = Email::widget();

        $this->assertNotSame($field, $field->maxlength(null));
        $this->assertNotSame($field, $field->minlength(null));
        $this->assertNotSame($field, $field->multiple());
        $this->assertNotSame($field, $field->pattern(null));
        $this->assertNotSame($field, $field->readonly());
        $this->assertNotSame($field, $field->required());
        $this->assertNotSame($field, $field->size(null));
        $this->assertNotSame($field, $field->disabled());
        $this->assertNotSame($field, $field->ariaDescribedBy(null));
        $this->assertNotSame($field, $field->ariaLabel(null));
        $this->assertNotSame($field, $field->autofocus());
        $this->assertNotSame($field, $field->tabIndex(null));
    }
}
