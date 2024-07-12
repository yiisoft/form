<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field\Password;
use Yiisoft\Form\PureField\InputData;
use Yiisoft\Form\Tests\Support\NullValidationRulesEnricher;
use Yiisoft\Form\Tests\Support\RequiredValidationRulesEnricher;
use Yiisoft\Form\Tests\Support\StubValidationRulesEnricher;
use Yiisoft\Form\Theme\ThemeContainer;

final class PasswordTest extends TestCase
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
                <label for="passwordform-old">Old password</label>
                <input type="password" id="passwordform-old" name="PasswordForm[old]" value>
                <div>Enter your old password.</div>
                </div>
                HTML,
                new InputData(
                    name: 'PasswordForm[old]',
                    value: '',
                    label: 'Old password',
                    hint: 'Enter your old password.',
                    id: 'passwordform-old',
                ),
            ],
            'input-valid-class' => [
                <<<HTML
                <div>
                <input type="password" class="valid" name="main" value>
                </div>
                HTML,
                new InputData(name: 'main', value: '', validationErrors: []),
                ['inputValidClass' => 'valid', 'inputInvalidClass' => 'invalid'],
            ],
            'container-valid-class' => [
                <<<HTML
                <div class="valid">
                <input type="password" name="main" value>
                </div>
                HTML,
                new InputData(name: 'main', value: '', validationErrors: []),
                ['validClass' => 'valid', 'invalidClass' => 'invalid'],
            ],
            'placeholder' => [
                <<<HTML
                <div>
                <input type="password" name="main" value placeholder="test">
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

        $result = Password::widget()->inputData($inputData)->render();

        $this->assertSame($expected, $result);
    }

    public function testMaxlength(): void
    {
        $result = Password::widget()
            ->name('newPassword')
            ->hideLabel()
            ->useContainer(false)
            ->maxlength(9)
            ->render();

        $this->assertSame(
            '<input type="password" name="newPassword" maxlength="9">',
            $result
        );
    }

    public function testMinlength(): void
    {
        $result = Password::widget()
            ->name('newPassword')
            ->hideLabel()
            ->useContainer(false)
            ->minlength(3)
            ->render();

        $this->assertSame(
            '<input type="password" name="newPassword" minlength="3">',
            $result
        );
    }

    public function testPattern(): void
    {
        $result = Password::widget()
            ->name('newPassword')
            ->hideLabel()
            ->useContainer(false)
            ->pattern('\d+')
            ->render();

        $this->assertSame(
            '<input type="password" name="newPassword" pattern="\d+">',
            $result
        );
    }

    public function testReadonly(): void
    {
        $result = Password::widget()
            ->name('newPassword')
            ->hideLabel()
            ->useContainer(false)
            ->readonly()
            ->render();

        $this->assertSame(
            '<input type="password" name="newPassword" readonly>',
            $result
        );
    }

    public function testRequired(): void
    {
        $result = Password::widget()
            ->name('newPassword')
            ->hideLabel()
            ->useContainer(false)
            ->required()
            ->render();

        $this->assertSame(
            '<input type="password" name="newPassword" required>',
            $result
        );
    }

    public function testDisabled(): void
    {
        $result = Password::widget()
            ->name('newPassword')
            ->hideLabel()
            ->useContainer(false)
            ->disabled()
            ->render();

        $this->assertSame(
            '<input type="password" name="newPassword" disabled>',
            $result
        );
    }

    public function testAriaDescribedBy(): void
    {
        $result = Password::widget()
            ->name('newPassword')
            ->hideLabel()
            ->useContainer(false)
            ->ariaDescribedBy('hint')
            ->render();

        $this->assertSame(
            '<input type="password" name="newPassword" aria-describedby="hint">',
            $result
        );
    }

    public function testAriaLabel(): void
    {
        $result = Password::widget()
            ->name('newPassword')
            ->hideLabel()
            ->useContainer(false)
            ->ariaLabel('test')
            ->render();

        $this->assertSame(
            '<input type="password" name="newPassword" aria-label="test">',
            $result
        );
    }

    public function testAutofocus(): void
    {
        $result = Password::widget()
            ->name('newPassword')
            ->hideLabel()
            ->useContainer(false)
            ->autofocus()
            ->render();

        $this->assertSame(
            '<input type="password" name="newPassword" autofocus>',
            $result
        );
    }

    public function testTabIndex(): void
    {
        $result = Password::widget()
            ->name('newPassword')
            ->hideLabel()
            ->useContainer(false)
            ->tabIndex(4)
            ->render();

        $this->assertSame(
            '<input type="password" name="newPassword" tabindex="4">',
            $result
        );
    }

    public function testSize(): void
    {
        $result = Password::widget()
            ->name('newPassword')
            ->hideLabel()
            ->useContainer(false)
            ->size(7)
            ->render();

        $this->assertSame(
            '<input type="password" name="newPassword" size="7">',
            $result
        );
    }

    public function testInvalidValue(): void
    {
        $widget = Password::widget()->value(42);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Password field requires a string or null value.');
        $widget->render();
    }

    public function testEnrichFromValidationRulesEnabled(): void
    {
        $html = Password::widget()
            ->enrichFromValidationRules()
            ->validationRulesEnricher(
                new StubValidationRulesEnricher([
                    'inputAttributes' => ['data-test' => 1],
                ])
            )
            ->render();

        $expected = <<<HTML
            <div>
            <input type="password" data-test="1">
            </div>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testEnrichFromValidationRulesEnabledWithProvidedRules(): void
    {
        $actualHtml = Password::widget()
            ->enrichFromValidationRules()
            ->validationRulesEnricher(new RequiredValidationRulesEnricher())
            ->inputData(new InputData(validationRules: [['required']]))
            ->render();
        $expectedHtml = <<<HTML
            <div>
            <input type="password" required>
            </div>
            HTML;

        $this->assertSame($expectedHtml, $actualHtml);
    }

    public function testEnrichFromValidationRulesEnabledWithNullProcessResult(): void
    {
        $actualHtml = Password::widget()
            ->enrichFromValidationRules()
            ->validationRulesEnricher(new NullValidationRulesEnricher())
            ->render();
        $expectedHtml = <<<HTML
            <div>
            <input type="password">
            </div>
            HTML;

        $this->assertSame($expectedHtml, $actualHtml);
    }

    public function testEnrichFromValidationRulesEnabledWithoutEnricher(): void
    {
        $actualHtml = Password::widget()
            ->enrichFromValidationRules()
            ->render();
        $expectedHtml = <<<HTML
            <div>
            <input type="password">
            </div>
            HTML;

        $this->assertSame($expectedHtml, $actualHtml);
    }

    public function testEnrichFromValidationRulesDisabled(): void
    {
        $html = Password::widget()
            ->validationRulesEnricher(
                new StubValidationRulesEnricher([
                    'inputAttributes' => ['data-test' => 1],
                ])
            )
            ->render();

        $expected = <<<HTML
            <div>
            <input type="password">
            </div>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testInvalidClassesWithCustomError(): void
    {
        $inputData = new InputData('company', '');

        $result = Password::widget()
            ->invalidClass('invalidWrap')
            ->inputValidClass('validWrap')
            ->inputInvalidClass('invalid')
            ->inputValidClass('valid')
            ->inputData($inputData)
            ->error('Value cannot be blank.')
            ->render();

        $expected = <<<HTML
            <div class="invalidWrap">
            <input type="password" class="invalid" name="company" value>
            <div>Value cannot be blank.</div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testImmutability(): void
    {
        $field = Password::widget();

        $this->assertNotSame($field, $field->size(null));
        $this->assertNotSame($field, $field->tabIndex(null));
        $this->assertNotSame($field, $field->autofocus());
        $this->assertNotSame($field, $field->ariaLabel(null));
        $this->assertNotSame($field, $field->ariaDescribedBy(null));
        $this->assertNotSame($field, $field->disabled());
        $this->assertNotSame($field, $field->required());
        $this->assertNotSame($field, $field->readonly());
        $this->assertNotSame($field, $field->pattern(null));
        $this->assertNotSame($field, $field->minlength(null));
        $this->assertNotSame($field, $field->maxlength(null));
        $this->assertNotSame($field, $field->enrichFromValidationRules());
        $this->assertNotSame($field, $field->validationRulesEnricher(null));
    }
}
