<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\YiisoftYiiValidatableForm\FormModelInputData;
use Yiisoft\Form\Field\Telephone;
use Yiisoft\Form\Tests\Support\Form\TelephoneForm;
use Yiisoft\Form\ThemeContainer;
use Yiisoft\Form\YiisoftYiiValidatableForm\ValidationRulesEnricher;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class TelephoneTest extends TestCase
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
        $result = Telephone::widget()
            ->inputData(new FormModelInputData(new TelephoneForm(), 'number'))
            ->render();

        $expected = <<<HTML
            <div>
            <label for="telephoneform-number">Phone</label>
            <input type="tel" id="telephoneform-number" name="TelephoneForm[number]" value>
            <div>Enter your phone.</div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testMaxlength(): void
    {
        $result = Telephone::widget()
            ->inputData(new FormModelInputData(new TelephoneForm(), 'main'))
            ->useContainer(false)
            ->hideLabel()
            ->maxlength(12)
            ->render();

        $this->assertSame(
            '<input type="tel" id="telephoneform-main" name="TelephoneForm[main]" maxlength="12">',
            $result
        );
    }

    public function testMinlength(): void
    {
        $result = Telephone::widget()
            ->inputData(new FormModelInputData(new TelephoneForm(), 'main'))
            ->useContainer(false)
            ->hideLabel()
            ->minlength(7)
            ->render();

        $this->assertSame(
            '<input type="tel" id="telephoneform-main" name="TelephoneForm[main]" minlength="7">',
            $result
        );
    }

    public function testPattern(): void
    {
        $result = Telephone::widget()
            ->inputData(new FormModelInputData(new TelephoneForm(), 'main'))
            ->useContainer(false)
            ->hideLabel()
            ->pattern('\d+')
            ->render();

        $this->assertSame(
            '<input type="tel" id="telephoneform-main" name="TelephoneForm[main]" pattern="\d+">',
            $result
        );
    }

    public function testReadonly(): void
    {
        $result = Telephone::widget()
            ->inputData(new FormModelInputData(new TelephoneForm(), 'main'))
            ->useContainer(false)
            ->hideLabel()
            ->readonly()
            ->render();

        $this->assertSame(
            '<input type="tel" id="telephoneform-main" name="TelephoneForm[main]" readonly>',
            $result
        );
    }

    public function testRequired(): void
    {
        $result = Telephone::widget()
            ->inputData(new FormModelInputData(new TelephoneForm(), 'main'))
            ->useContainer(false)
            ->hideLabel()
            ->required()
            ->render();

        $this->assertSame(
            '<input type="tel" id="telephoneform-main" name="TelephoneForm[main]" required>',
            $result
        );
    }

    public function testDisabled(): void
    {
        $result = Telephone::widget()
            ->inputData(new FormModelInputData(new TelephoneForm(), 'main'))
            ->useContainer(false)
            ->hideLabel()
            ->disabled()
            ->render();

        $this->assertSame(
            '<input type="tel" id="telephoneform-main" name="TelephoneForm[main]" disabled>',
            $result
        );
    }

    public function testAriaDescribedBy(): void
    {
        $result = Telephone::widget()
            ->inputData(new FormModelInputData(new TelephoneForm(), 'main'))
            ->useContainer(false)
            ->hideLabel()
            ->ariaDescribedBy('hint')
            ->render();

        $this->assertSame(
            '<input type="tel" id="telephoneform-main" name="TelephoneForm[main]" aria-describedby="hint">',
            $result
        );
    }

    public function testAriaLabel(): void
    {
        $result = Telephone::widget()
            ->inputData(new FormModelInputData(new TelephoneForm(), 'main'))
            ->useContainer(false)
            ->hideLabel()
            ->ariaLabel('test')
            ->render();

        $this->assertSame(
            '<input type="tel" id="telephoneform-main" name="TelephoneForm[main]" aria-label="test">',
            $result
        );
    }

    public function testAutofocus(): void
    {
        $result = Telephone::widget()
            ->inputData(new FormModelInputData(new TelephoneForm(), 'main'))
            ->useContainer(false)
            ->hideLabel()
            ->autofocus()
            ->render();

        $this->assertSame(
            '<input type="tel" id="telephoneform-main" name="TelephoneForm[main]" autofocus>',
            $result
        );
    }

    public function testTabIndex(): void
    {
        $result = Telephone::widget()
            ->inputData(new FormModelInputData(new TelephoneForm(), 'main'))
            ->useContainer(false)
            ->hideLabel()
            ->tabIndex(5)
            ->render();

        $this->assertSame(
            '<input type="tel" id="telephoneform-main" name="TelephoneForm[main]" tabindex="5">',
            $result
        );
    }

    public function testSize(): void
    {
        $result = Telephone::widget()
            ->inputData(new FormModelInputData(new TelephoneForm(), 'main'))
            ->useContainer(false)
            ->hideLabel()
            ->size(9)
            ->render();

        $this->assertSame(
            '<input type="tel" id="telephoneform-main" name="TelephoneForm[main]" size="9">',
            $result
        );
    }

    public function dataEnrichFromValidationRules(): array
    {
        return [
            'required' => [
                '<input type="tel" id="telephoneform-office1" name="TelephoneForm[office1]" required>',
                'office1',
            ],
            'has-length' => [
                '<input type="tel" id="telephoneform-office2" name="TelephoneForm[office2]" maxlength="199" minlength="10">',
                'office2',
            ],
            'regex' => [
                '<input type="tel" id="telephoneform-code" name="TelephoneForm[code]" pattern="\w+">',
                'code',
            ],
            'regex-not' => [
                '<input type="tel" id="telephoneform-nocode" name="TelephoneForm[nocode]">',
                'nocode',
            ],
            'required-with-when' => [
                '<input type="tel" id="telephoneform-requiredwhen" name="TelephoneForm[requiredWhen]">',
                'requiredWhen',
            ],
        ];
    }

    /**
     * @dataProvider dataEnrichFromValidationRules
     */
    public function testEnrichFromValidationRules(string $expected, string $attribute): void
    {
        $field = Telephone::widget()
            ->inputData(new FormModelInputData(new TelephoneForm(), $attribute))
            ->hideLabel()
            ->enrichFromValidationRules(true)
            ->useContainer(false);

        $this->assertSame($expected, $field->render());
    }

    public function testInvalidValue(): void
    {
        $widget = Telephone::widget()
            ->inputData(new FormModelInputData(new TelephoneForm(), 'age'));

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Telephone field requires a string or null value.');
        $widget->render();
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
    }
}
