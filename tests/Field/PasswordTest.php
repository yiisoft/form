<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\YiiValidator\FormModelInputData;
use Yiisoft\Form\Field\Password;
use Yiisoft\Form\Tests\Support\Form\PasswordForm;
use Yiisoft\Form\ThemeContainer;
use Yiisoft\Form\YiiValidator\ValidationRulesEnricher;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class PasswordTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer());
        ThemeContainer::initialize(
            validationRulesEnricher: new ValidationRulesEnricher()
        );
    }

    public function testBase(): void
    {
        $result = Password::widget()
            ->inputData(new FormModelInputData(new PasswordForm(), 'old'))
            ->render();

        $expected = <<<HTML
            <div>
            <label for="passwordform-old">Old password</label>
            <input type="password" id="passwordform-old" name="PasswordForm[old]" value>
            <div>Enter your old password.</div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testMaxlength(): void
    {
        $result = Password::widget()
            ->inputData(new FormModelInputData(new PasswordForm(), 'post'))
            ->hideLabel()
            ->useContainer(false)
            ->maxlength(9)
            ->render();

        $this->assertSame(
            '<input type="password" id="passwordform-post" name="PasswordForm[post]" maxlength="9">',
            $result
        );
    }

    public function testMinlength(): void
    {
        $result = Password::widget()
            ->inputData(new FormModelInputData(new PasswordForm(), 'post'))
            ->hideLabel()
            ->useContainer(false)
            ->minlength(3)
            ->render();

        $this->assertSame(
            '<input type="password" id="passwordform-post" name="PasswordForm[post]" minlength="3">',
            $result
        );
    }

    public function testPattern(): void
    {
        $result = Password::widget()
            ->inputData(new FormModelInputData(new PasswordForm(), 'post'))
            ->hideLabel()
            ->useContainer(false)
            ->pattern('\d+')
            ->render();

        $this->assertSame(
            '<input type="password" id="passwordform-post" name="PasswordForm[post]" pattern="\d+">',
            $result
        );
    }

    public function testReadonly(): void
    {
        $result = Password::widget()
            ->inputData(new FormModelInputData(new PasswordForm(), 'post'))
            ->hideLabel()
            ->useContainer(false)
            ->readonly()
            ->render();

        $this->assertSame(
            '<input type="password" id="passwordform-post" name="PasswordForm[post]" readonly>',
            $result
        );
    }

    public function testRequired(): void
    {
        $result = Password::widget()
            ->inputData(new FormModelInputData(new PasswordForm(), 'post'))
            ->hideLabel()
            ->useContainer(false)
            ->required()
            ->render();

        $this->assertSame(
            '<input type="password" id="passwordform-post" name="PasswordForm[post]" required>',
            $result
        );
    }

    public function testDisabled(): void
    {
        $result = Password::widget()
            ->inputData(new FormModelInputData(new PasswordForm(), 'post'))
            ->hideLabel()
            ->useContainer(false)
            ->disabled()
            ->render();

        $this->assertSame(
            '<input type="password" id="passwordform-post" name="PasswordForm[post]" disabled>',
            $result
        );
    }

    public function testAriaDescribedBy(): void
    {
        $result = Password::widget()
            ->inputData(new FormModelInputData(new PasswordForm(), 'post'))
            ->hideLabel()
            ->useContainer(false)
            ->ariaDescribedBy('hint')
            ->render();

        $this->assertSame(
            '<input type="password" id="passwordform-post" name="PasswordForm[post]" aria-describedby="hint">',
            $result
        );
    }

    public function testAriaLabel(): void
    {
        $result = Password::widget()
            ->inputData(new FormModelInputData(new PasswordForm(), 'post'))
            ->hideLabel()
            ->useContainer(false)
            ->ariaLabel('test')
            ->render();

        $this->assertSame(
            '<input type="password" id="passwordform-post" name="PasswordForm[post]" aria-label="test">',
            $result
        );
    }

    public function testAutofocus(): void
    {
        $result = Password::widget()
            ->inputData(new FormModelInputData(new PasswordForm(), 'post'))
            ->hideLabel()
            ->useContainer(false)
            ->autofocus()
            ->render();

        $this->assertSame(
            '<input type="password" id="passwordform-post" name="PasswordForm[post]" autofocus>',
            $result
        );
    }

    public function testTabIndex(): void
    {
        $result = Password::widget()
            ->inputData(new FormModelInputData(new PasswordForm(), 'post'))
            ->hideLabel()
            ->useContainer(false)
            ->tabIndex(4)
            ->render();

        $this->assertSame(
            '<input type="password" id="passwordform-post" name="PasswordForm[post]" tabindex="4">',
            $result
        );
    }

    public function testSize(): void
    {
        $result = Password::widget()
            ->inputData(new FormModelInputData(new PasswordForm(), 'post'))
            ->hideLabel()
            ->useContainer(false)
            ->size(7)
            ->render();

        $this->assertSame(
            '<input type="password" id="passwordform-post" name="PasswordForm[post]" size="7">',
            $result
        );
    }

    public function testInvalidValue(): void
    {
        $widget = Password::widget()
            ->inputData(new FormModelInputData(new PasswordForm(), 'age'));

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Password field requires a string or null value.');
        $widget->render();
    }

    public function dataEnrichFromValidationRules(): array
    {
        return [
            'required' => [
                '<input type="password" id="passwordform-entry1" name="PasswordForm[entry1]" required>',
                'entry1',
            ],
            'has-length' => [
                '<input type="password" id="passwordform-entry2" name="PasswordForm[entry2]" maxlength="199" minlength="10">',
                'entry2',
            ],
            'regex' => [
                '<input type="password" id="passwordform-code" name="PasswordForm[code]" pattern="\w+">',
                'code',
            ],
            'regex-not' => [
                '<input type="password" id="passwordform-nocode" name="PasswordForm[nocode]">',
                'nocode',
            ],
            'required-with-when' => [
                '<input type="password" id="passwordform-requiredwhen" name="PasswordForm[requiredWhen]">',
                'requiredWhen',
            ],
        ];
    }

    /**
     * @dataProvider dataEnrichFromValidationRules
     */
    public function testEnrichFromValidationRules(string $expected, string $attribute): void
    {
        $field = Password::widget()
            ->inputData(new FormModelInputData(new PasswordForm(), $attribute))
            ->hideLabel()
            ->enrichFromValidationRules(true)
            ->useContainer(false);

        $this->assertSame($expected, $field->render());
    }
}
