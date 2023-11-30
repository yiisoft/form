<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field\Base;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field\Base\InputData\FormModelInputData;
use Yiisoft\Form\Tests\Support\Form\DateForm;
use Yiisoft\Form\Tests\Support\StubDateTimeInputField;
use Yiisoft\Form\ThemeContainer;
use Yiisoft\Form\YiiValidatorRulesEnricher;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class DateTimeInputFieldTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer());
        ThemeContainer::initialize(
            validationRulesEnricher: new YiiValidatorRulesEnricher()
        );
    }

    public function testMax(): void
    {
        $result = StubDateTimeInputField::widget()
            ->inputData(new FormModelInputData(new DateForm(), 'endDate'))
            ->hideLabel()
            ->max('2030-12-31')
            ->render();

        $expected = <<<'HTML'
        <div>
        <input type="datetime" id="dateform-enddate" name="DateForm[endDate]" max="2030-12-31">
        </div>
        HTML;

        $this->assertSame($expected, $result);
    }

    public function testMin(): void
    {
        $result = StubDateTimeInputField::widget()
            ->inputData(new FormModelInputData(new DateForm(), 'endDate'))
            ->hideLabel()
            ->min('1999-01-01')
            ->render();

        $expected = <<<'HTML'
        <div>
        <input type="datetime" id="dateform-enddate" name="DateForm[endDate]" min="1999-01-01">
        </div>
        HTML;

        $this->assertSame($expected, $result);
    }

    public function testAriaDescribedBy(): void
    {
        $result = StubDateTimeInputField::widget()
            ->inputData(new FormModelInputData(new DateForm(), 'endDate'))
            ->hideLabel()
            ->ariaDescribedBy('hint')
            ->render();

        $expected = <<<'HTML'
        <div>
        <input type="datetime" id="dateform-enddate" name="DateForm[endDate]" aria-describedby="hint">
        </div>
        HTML;

        $this->assertSame($expected, $result);
    }

    public function testAriaLabel(): void
    {
        $result = StubDateTimeInputField::widget()
            ->inputData(new FormModelInputData(new DateForm(), 'endDate'))
            ->hideLabel()
            ->ariaLabel('test')
            ->render();

        $expected = <<<'HTML'
        <div>
        <input type="datetime" id="dateform-enddate" name="DateForm[endDate]" aria-label="test">
        </div>
        HTML;

        $this->assertSame($expected, $result);
    }

    public function testAutofocus(): void
    {
        $result = StubDateTimeInputField::widget()
            ->inputData(new FormModelInputData(new DateForm(), 'endDate'))
            ->hideLabel()
            ->autofocus()
            ->render();

        $expected = <<<'HTML'
        <div>
        <input type="datetime" id="dateform-enddate" name="DateForm[endDate]" autofocus>
        </div>
        HTML;

        $this->assertSame($expected, $result);
    }

    public function testTabIndex(): void
    {
        $result = StubDateTimeInputField::widget()
            ->inputData(new FormModelInputData(new DateForm(), 'endDate'))
            ->hideLabel()
            ->tabIndex(5)
            ->render();

        $expected = <<<'HTML'
        <div>
        <input type="datetime" id="dateform-enddate" name="DateForm[endDate]" tabindex="5">
        </div>
        HTML;

        $this->assertSame($expected, $result);
    }

    public function testReadonly(): void
    {
        $result = StubDateTimeInputField::widget()
            ->inputData(new FormModelInputData(new DateForm(), 'endDate'))
            ->hideLabel()
            ->readonly()
            ->render();

        $expected = <<<'HTML'
        <div>
        <input type="datetime" id="dateform-enddate" name="DateForm[endDate]" readonly>
        </div>
        HTML;

        $this->assertSame($expected, $result);
    }

    public function testRequired(): void
    {
        $result = StubDateTimeInputField::widget()
            ->inputData(new FormModelInputData(new DateForm(), 'endDate'))
            ->hideLabel()
            ->required()
            ->render();

        $expected = <<<'HTML'
        <div>
        <input type="datetime" id="dateform-enddate" name="DateForm[endDate]" required>
        </div>
        HTML;

        $this->assertSame($expected, $result);
    }

    public function testDisabled(): void
    {
        $result = StubDateTimeInputField::widget()
            ->inputData(new FormModelInputData(new DateForm(), 'endDate'))
            ->hideLabel()
            ->disabled()
            ->render();

        $expected = <<<'HTML'
        <div>
        <input type="datetime" id="dateform-enddate" name="DateForm[endDate]" disabled>
        </div>
        HTML;

        $this->assertSame($expected, $result);
    }

    public function testEnrichFromValidationRules(): void
    {
        $result = StubDateTimeInputField::widget()
            ->inputData(new FormModelInputData(new DateForm(), 'main'))
            ->hideLabel()
            ->enrichFromValidationRules(true)
            ->render();

        $expected = <<<HTML
            <div>
            <input type="datetime" id="dateform-main" name="DateForm[main]" required>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testEnrichFromValidationRulesWithWhen(): void
    {
        $result = StubDateTimeInputField::widget()
            ->inputData(new FormModelInputData(new DateForm(), 'second'))
            ->hideLabel()
            ->enrichFromValidationRules(true)
            ->render();

        $expected = <<<HTML
            <div>
            <input type="datetime" id="dateform-second" name="DateForm[second]">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testInvalidValue(): void
    {
        $widget = StubDateTimeInputField::widget()
            ->inputData(new FormModelInputData(new DateForm(), 'age'));

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('StubDateTimeInputField field requires a string or null value.');
        $widget->render();
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
    }
}
