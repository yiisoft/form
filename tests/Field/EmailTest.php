<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\YiisoftFormModel\FormModelInputData;
use Yiisoft\Form\Field\Email;
use Yiisoft\Form\Tests\Support\Form\EmailForm;
use Yiisoft\Form\ThemeContainer;
use Yiisoft\Form\YiisoftFormModel\ValidationRulesEnricher;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class EmailTest extends TestCase
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
        $result = Email::widget()
            ->inputData(new FormModelInputData(new EmailForm(), 'main'))
            ->render();

        $expected = <<<HTML
            <div>
            <label for="emailform-main">Main email</label>
            <input type="email" id="emailform-main" name="EmailForm[main]" value>
            <div>Email for notifications.</div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testMaxlength(): void
    {
        $result = Email::widget()
            ->inputData(new FormModelInputData(new EmailForm(), 'second'))
            ->maxlength(99)
            ->render();

        $expected = <<<HTML
            <div>
            <label for="emailform-second">Second</label>
            <input type="email" id="emailform-second" name="EmailForm[second]" maxlength="99">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testMinlength(): void
    {
        $result = Email::widget()
            ->inputData(new FormModelInputData(new EmailForm(), 'second'))
            ->minlength(5)
            ->render();

        $expected = <<<HTML
            <div>
            <label for="emailform-second">Second</label>
            <input type="email" id="emailform-second" name="EmailForm[second]" minlength="5">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testMultiple(): void
    {
        $result = Email::widget()
            ->inputData(new FormModelInputData(new EmailForm(), 'second'))
            ->multiple()
            ->render();

        $expected = <<<HTML
            <div>
            <label for="emailform-second">Second</label>
            <input type="email" id="emailform-second" name="EmailForm[second]" multiple>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testPattern(): void
    {
        $result = Email::widget()
            ->inputData(new FormModelInputData(new EmailForm(), 'second'))
            ->pattern('\w+@\w+')
            ->render();

        $expected = <<<HTML
            <div>
            <label for="emailform-second">Second</label>
            <input type="email" id="emailform-second" name="EmailForm[second]" pattern="\w+@\w+">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testReadonly(): void
    {
        $result = Email::widget()
            ->inputData(new FormModelInputData(new EmailForm(), 'second'))
            ->readonly()
            ->render();

        $expected = <<<HTML
            <div>
            <label for="emailform-second">Second</label>
            <input type="email" id="emailform-second" name="EmailForm[second]" readonly>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testRequired(): void
    {
        $result = Email::widget()
            ->inputData(new FormModelInputData(new EmailForm(), 'second'))
            ->required()
            ->render();

        $expected = <<<HTML
            <div>
            <label for="emailform-second">Second</label>
            <input type="email" id="emailform-second" name="EmailForm[second]" required>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testSize(): void
    {
        $result = Email::widget()
            ->inputData(new FormModelInputData(new EmailForm(), 'second'))
            ->size(99)
            ->render();

        $expected = <<<HTML
            <div>
            <label for="emailform-second">Second</label>
            <input type="email" id="emailform-second" name="EmailForm[second]" size="99">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testDisabled(): void
    {
        $result = Email::widget()
            ->inputData(new FormModelInputData(new EmailForm(), 'second'))
            ->disabled()
            ->render();

        $expected = <<<HTML
            <div>
            <label for="emailform-second">Second</label>
            <input type="email" id="emailform-second" name="EmailForm[second]" disabled>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testAriaDescribedBy(): void
    {
        $result = Email::widget()
            ->inputData(new FormModelInputData(new EmailForm(), 'second'))
            ->ariaDescribedBy('hint')
            ->render();

        $expected = <<<HTML
            <div>
            <label for="emailform-second">Second</label>
            <input type="email" id="emailform-second" name="EmailForm[second]" aria-describedby="hint">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testAriaLabel(): void
    {
        $result = Email::widget()
            ->inputData(new FormModelInputData(new EmailForm(), 'second'))
            ->ariaLabel('test')
            ->render();

        $expected = <<<HTML
            <div>
            <label for="emailform-second">Second</label>
            <input type="email" id="emailform-second" name="EmailForm[second]" aria-label="test">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testAutofocus(): void
    {
        $result = Email::widget()
            ->inputData(new FormModelInputData(new EmailForm(), 'second'))
            ->autofocus()
            ->render();

        $expected = <<<HTML
            <div>
            <label for="emailform-second">Second</label>
            <input type="email" id="emailform-second" name="EmailForm[second]" autofocus>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testTabIndex(): void
    {
        $result = Email::widget()
            ->inputData(new FormModelInputData(new EmailForm(), 'second'))
            ->tabIndex(2)
            ->render();

        $expected = <<<HTML
            <div>
            <label for="emailform-second">Second</label>
            <input type="email" id="emailform-second" name="EmailForm[second]" tabindex="2">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testInvalidValue(): void
    {
        $field = Email::widget()->inputData(new FormModelInputData(new EmailForm(), 'age'));

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Email field requires a string or null value.');
        $field->render();
    }

    public function dataEnrichFromValidationRules(): array
    {
        return [
            'required' => [
                '<input type="email" id="emailform-cto" name="EmailForm[cto]" required>',
                'cto',
            ],
            'has-length' => [
                '<input type="email" id="emailform-teamlead" name="EmailForm[teamlead]" maxlength="199" minlength="10">',
                'teamlead',
            ],
            'regex' => [
                '<input type="email" id="emailform-code" name="EmailForm[code]" pattern="\w+@\w+">',
                'code',
            ],
            'regex-not' => [
                '<input type="email" id="emailform-nocode" name="EmailForm[nocode]">',
                'nocode',
            ],
            'required-with-when' => [
                '<input type="email" id="emailform-requiredwhen" name="EmailForm[requiredWhen]">',
                'requiredWhen',
            ],
        ];
    }

    /**
     * @dataProvider dataEnrichFromValidationRules
     */
    public function testEnrichFromValidationRules(string $expected, string $attribute): void
    {
        $field = Email::widget()
            ->inputData(new FormModelInputData(new EmailForm(), $attribute))
            ->hideLabel()
            ->enrichFromValidationRules(true)
            ->useContainer(false);

        $this->assertSame($expected, $field->render());
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
