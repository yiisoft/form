<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field\Text;
use Yiisoft\Form\PureField\InputData;
use Yiisoft\Form\Tests\Support\RequiredValidationRulesEnricher;
use Yiisoft\Form\Tests\Support\StubValidationRulesEnricher;
use Yiisoft\Form\Theme\ThemeContainer;

final class TextTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        ThemeContainer::initialize();
    }

    public function testBase(): void
    {
        $inputData = new InputData(
            name: 'TextForm[name]',
            value: '',
            label: 'Name',
            hint: 'Input your full name.',
            placeholder: 'Type your name here',
            id: 'textform-name',
            validationErrors: ['Value cannot be blank.'],
        );

        $result = Text::widget()->inputData($inputData)->render();

        $expected = <<<HTML
            <div>
            <label for="textform-name">Name</label>
            <input type="text" id="textform-name" name="TextForm[name]" value placeholder="Type your name here">
            <div>Input your full name.</div>
            <div>Value cannot be blank.</div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testEmpty(): void
    {
        $result = Text::widget()->render();

        $expected = <<<HTML
            <div>
            <input type="text">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testCustomName(): void
    {
        $result = Text::widget()->name('the-name')->render();

        $expected = <<<HTML
            <div>
            <input type="text" name="the-name">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testCustomNameAfterInputData(): void
    {
        $inputData = new InputData('test', '');

        $result = Text::widget()
            ->inputData($inputData)
            ->name('the-name')
            ->render();

        $expected = <<<HTML
            <div>
            <input type="text" name="the-name" value>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testCustomNameBeforeInputData(): void
    {
        $inputData = new InputData('test', '');

        $result = Text::widget()
            ->name('the-name')
            ->inputData($inputData)
            ->render();

        $expected = <<<HTML
            <div>
            <input type="text" name="test" value>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testCustomValueAfterInputData(): void
    {
        $inputData = new InputData('test', '42');

        $result = Text::widget()
            ->inputData($inputData)
            ->value('7')
            ->render();

        $expected = <<<HTML
            <div>
            <input type="text" name="test" value="7">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testCustomValueBeforeInputData(): void
    {
        $inputData = new InputData('test', '42');

        $result = Text::widget()
            ->value('7')
            ->inputData($inputData)
            ->render();

        $expected = <<<HTML
            <div>
            <input type="text" name="test" value="42">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testInvalidValue(): void
    {
        $widget = Text::widget()->value(7);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Text field requires a string or null value.');
        $widget->render();
    }

    public function testEnrichFromValidationRulesEnabled(): void
    {
        ThemeContainer::initialize(
            validationRulesEnricher: new StubValidationRulesEnricher([
                'inputAttributes' => ['data-test' => 1],
            ]),
        );

        $html = Text::widget()->enrichFromValidationRules()->render();

        $expected = <<<HTML
            <div>
            <input type="text" data-test="1">
            </div>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testEnrichFromValidationRulesEnabledWithProvidedRules(): void
    {
        ThemeContainer::initialize(validationRulesEnricher: new RequiredValidationRulesEnricher());

        $actualHtml = Text::widget()
            ->enrichFromValidationRules()
            ->inputData(new InputData(validationRules: [['required']]))
            ->render();
        $expectedHtml = <<<HTML
            <div>
            <input type="text" required>
            </div>
            HTML;

        $this->assertSame($expectedHtml, $actualHtml);
    }

    public function testEnrichFromValidationRulesDisabled(): void
    {
        ThemeContainer::initialize(
            validationRulesEnricher: new StubValidationRulesEnricher([
                'inputAttributes' => ['data-test' => 1],
            ]),
        );

        $html = Text::widget()->render();

        $expected = <<<HTML
            <div>
            <input type="text">
            </div>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testWithoutContainer(): void
    {
        $inputData = new InputData(
            name: 'job',
            value: '',
            validationErrors: [],
        );

        $result = Text::widget()
            ->inputData($inputData)
            ->useContainer(false)
            ->render();

        $this->assertSame('<input type="text" name="job" value>', $result);
    }

    public function testCustomContainerTag(): void
    {
        $inputData = new InputData(
            name: 'job',
            value: '',
            validationErrors: [],
        );

        $result = Text::widget()
            ->inputData($inputData)
            ->containerTag('section')
            ->render();

        $expected = <<<HTML
            <section>
            <input type="text" name="job" value>
            </section>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testEmptyContainerTag(): void
    {
        $widget = Text::widget();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Tag name cannot be empty.');
        $widget->containerTag('');
    }

    public function testContainerAttributes(): void
    {
        $inputData = new InputData(
            name: 'job',
            value: '',
            validationErrors: [],
        );

        $result = Text::widget()
            ->inputData($inputData)
            ->containerAttributes(['class' => 'wrapper', 'id' => 'main'])
            ->render();

        $expected = <<<HTML
            <div id="main" class="wrapper">
            <input type="text" name="job" value>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testCustomTemplate(): void
    {
        $inputData = new InputData(
            name: 'TextForm[name]',
            value: '',
            id: 'textform-name',
            label: 'Name',
            placeholder: 'Typed your name here',
            hint: 'Input your full name.',
            validationErrors: ['Value cannot be blank.'],
        );

        $result = Text::widget()
            ->inputData($inputData)
            ->template("<div class=\"wrap\">\n{hint}\n{label}\n{error}\n{input}\n</div>")
            ->render();

        $expected = <<<HTML
            <div>
            <div class="wrap">
            <div>Input your full name.</div>
            <label for="textform-name">Name</label>
            <div>Value cannot be blank.</div>
            <input type="text" id="textform-name" name="TextForm[name]" value placeholder="Typed your name here">
            </div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testCustomInputId(): void
    {
        $inputData = new InputData(
            name: 'job',
            value: '',
            label: 'Job',
            validationErrors: [],
        );

        $result = Text::widget()
            ->inputData($inputData)
            ->inputId('CustomID')
            ->render();

        $expected = <<<HTML
            <div>
            <label for="CustomID">Job</label>
            <input type="text" id="CustomID" name="job" value>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testDoNotSetInputId(): void
    {
        $inputData = new InputData(
            name: 'job',
            value: '',
            label: 'Job',
            validationErrors: [],
        );

        $result = Text::widget()
            ->inputData($inputData)
            ->shouldSetInputId(false)
            ->render();

        $expected = <<<HTML
            <div>
            <label>Job</label>
            <input type="text" name="job" value>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testCustomLabelConfig(): void
    {
        $inputData = new InputData(
            name: 'job',
            value: '',
            id: 'job-id',
            label: 'Job',
            validationErrors: [],
        );

        $result = Text::widget()
            ->inputData($inputData)
            ->labelConfig([
                'setFor()' => [false],
                'content()' => ['Your job'],
            ])
            ->render();

        $expected = <<<HTML
            <div>
            <label>Your job</label>
            <input type="text" id="job-id" name="job" value>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testCustomLabel(): void
    {
        $inputData = new InputData(
            name: 'job',
            value: '',
            label: 'Job',
            validationErrors: [],
        );

        $result = Text::widget()
            ->inputData($inputData)
            ->label('Your job')
            ->render();

        $expected = <<<HTML
            <div>
            <label>Your job</label>
            <input type="text" name="job" value>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testCustomHintConfig(): void
    {
        $inputData = new InputData(
            name: 'TextForm[name]',
            value: '',
            hint: 'Input your full name.',
        );

        $result = Text::widget()
            ->inputData($inputData)
            ->hintConfig([
                'tag()' => ['b'],
                'attributes()' => [['class' => 'red']],
            ])
            ->render();

        $expected = <<<HTML
            <div>
            <input type="text" name="TextForm[name]" value>
            <b class="red">Input your full name.</b>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testCustomHint(): void
    {
        $inputData = new InputData(
            name: 'TextForm[name]',
            value: '',
            hint: 'Input your full name.',
        );

        $result = Text::widget()
            ->inputData($inputData)
            ->hint('Custom hint.')
            ->render();

        $expected = <<<HTML
            <div>
            <input type="text" name="TextForm[name]" value>
            <div>Custom hint.</div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testCustomErrorConfig(): void
    {
        $inputData = new InputData(
            name: 'test',
            validationErrors: ['Value cannot be blank.'],
        );

        $result = Text::widget()
            ->inputData($inputData)
            ->errorConfig([
                'tag()' => ['b'],
                'attributes()' => [['class' => 'red']],
            ])
            ->render();

        $expected = <<<HTML
            <div>
            <input type="text" name="test">
            <b class="red">Value cannot be blank.</b>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testOverridePlaceholder(): void
    {
        $inputData = new InputData(
            name: 'TextForm[name]',
            value: '',
            placeholder: 'Your name',
        );

        $result = Text::widget()
            ->inputData($inputData)
            ->placeholder('Input your pretty name')
            ->render();

        $expected = <<<HTML
            <div>
            <input type="text" name="TextForm[name]" value placeholder="Input your pretty name">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testDoNotSetPlaceholder(): void
    {
        $inputData = new InputData(
            name: 'TextForm[name]',
            value: '',
            placeholder: 'Your name',
        );

        $result = Text::widget()
            ->inputData($inputData)
            ->usePlaceholder(false)
            ->render();

        $expected = <<<HTML
            <div>
            <input type="text" name="TextForm[name]" value>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testAddInputAttributes(): void
    {
        $inputData = new InputData('job', '');

        $result = Text::widget()
            ->inputData($inputData)
            ->addInputAttributes(['class' => 'red'])
            ->render();

        $expected = <<<HTML
            <div>
            <input type="text" class="red" name="job" value>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testInputAttributesOverridePlaceholderFromForm(): void
    {
        $inputData = new InputData('job', '', placeholder: 'Your name');

        $result = Text::widget()
            ->inputData($inputData)
            ->inputAttributes(['placeholder' => 'Input your pretty name'])
            ->render();

        $expected = <<<HTML
            <div>
            <input type="text" name="job" value placeholder="Input your pretty name">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testInputAttributesOverrideIdFromForm(): void
    {
        $inputData = new InputData('name', '', id: 'test-id', label: 'Name');

        $result = Text::widget()
            ->inputData($inputData)
            ->inputAttributes(['id' => 'MyID'])
            ->render();

        $expected = <<<HTML
            <div>
            <label for="MyID">Name</label>
            <input type="text" id="MyID" name="name" value>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testInputIdOverrideIdFromAttributes(): void
    {
        $inputData = new InputData('name', '', id: 'test-id', label: 'Name');

        $result = Text::widget()
            ->inputData($inputData)
            ->inputId('CustomID')
            ->inputAttributes(['id' => 'MyID'])
            ->render();

        $expected = <<<HTML
            <div>
            <label for="CustomID">Name</label>
            <input type="text" id="CustomID" name="name" value>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testDirname(): void
    {
        $inputData = new InputData('job', '');

        $result = Text::widget()
            ->inputData($inputData)
            ->dirname('test')
            ->render();

        $expected = <<<HTML
            <div>
            <input type="text" name="job" value dirname="test">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testMaxlength(): void
    {
        $inputData = new InputData('job', '');

        $result = Text::widget()
            ->inputData($inputData)
            ->maxlength(5)
            ->render();

        $expected = <<<HTML
            <div>
            <input type="text" name="job" value maxlength="5">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testMinlength(): void
    {
        $inputData = new InputData('job', '');

        $result = Text::widget()
            ->inputData($inputData)
            ->minlength(5)
            ->render();

        $expected = <<<HTML
            <div>
            <input type="text" name="job" value minlength="5">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testPattern(): void
    {
        $inputData = new InputData('job', '');

        $result = Text::widget()
            ->inputData($inputData)
            ->pattern('[0-9]{3}')
            ->render();

        $expected = <<<HTML
            <div>
            <input type="text" name="job" value pattern="[0-9]{3}">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testSize(): void
    {
        $inputData = new InputData('job', '');

        $result = Text::widget()
            ->inputData($inputData)
            ->size(12)
            ->render();

        $expected = <<<HTML
            <div>
            <input type="text" name="job" value size="12">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testReadonly(): void
    {
        $inputData = new InputData('job', '');

        $result = Text::widget()
            ->inputData($inputData)
            ->useContainer(false)
            ->hideLabel()
            ->readonly()
            ->render();

        $this->assertSame(
            '<input type="text" name="job" value readonly>',
            $result
        );
    }

    public function testRequired(): void
    {
        $inputData = new InputData('job', '');

        $result = Text::widget()
            ->inputData($inputData)
            ->useContainer(false)
            ->hideLabel()
            ->required()
            ->render();

        $this->assertSame(
            '<input type="text" name="job" value required>',
            $result
        );
    }

    public function testDisabled(): void
    {
        $inputData = new InputData('job', '');

        $result = Text::widget()
            ->inputData($inputData)
            ->useContainer(false)
            ->hideLabel()
            ->disabled()
            ->render();

        $this->assertSame(
            '<input type="text" name="job" value disabled>',
            $result
        );
    }

    public function testAriaDescribedBy(): void
    {
        $inputData = new InputData('job', '');

        $result = Text::widget()
            ->inputData($inputData)
            ->useContainer(false)
            ->hideLabel()
            ->ariaDescribedBy('hint')
            ->render();

        $this->assertSame(
            '<input type="text" name="job" value aria-describedby="hint">',
            $result
        );
    }

    public function testAriaLabel(): void
    {
        $inputData = new InputData('job', '');

        $result = Text::widget()
            ->inputData($inputData)
            ->useContainer(false)
            ->hideLabel()
            ->ariaLabel('test')
            ->render();

        $this->assertSame(
            '<input type="text" name="job" value aria-label="test">',
            $result
        );
    }

    public function testAutofocus(): void
    {
        $inputData = new InputData('job', '');

        $result = Text::widget()
            ->inputData($inputData)
            ->useContainer(false)
            ->hideLabel()
            ->autofocus()
            ->render();

        $this->assertSame(
            '<input type="text" name="job" value autofocus>',
            $result
        );
    }

    public function testTabIndex(): void
    {
        $inputData = new InputData('job', '');

        $result = Text::widget()
            ->inputData($inputData)
            ->useContainer(false)
            ->hideLabel()
            ->tabIndex(5)
            ->render();

        $this->assertSame(
            '<input type="text" name="job" value tabindex="5">',
            $result
        );
    }

    public function testValidationClassForNonValidatedForm(): void
    {
        $inputData = new InputData('job', '');

        $result = Text::widget()
            ->invalidClass('invalid')
            ->validClass('valid')
            ->inputData($inputData)
            ->render();

        $expected = <<<HTML
            <div>
            <input type="text" name="job" value>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testInvalidClass(): void
    {
        $inputData = new InputData(
            name: 'company',
            value: '',
            validationErrors: ['Value cannot be blank.'],
        );

        $result = Text::widget()
            ->invalidClass('invalid')
            ->validClass('valid')
            ->inputData($inputData)
            ->render();

        $expected = <<<HTML
            <div class="invalid">
            <input type="text" name="company" value>
            <div>Value cannot be blank.</div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testValidClass(): void
    {
        $inputData = new InputData(
            name: 'job',
            value: '',
            validationErrors: [],
        );

        $result = Text::widget()
            ->invalidClass('invalid')
            ->validClass('valid')
            ->inputData($inputData)
            ->render();

        $expected = <<<HTML
            <div class="valid">
            <input type="text" name="job" value>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testInputInvalidClass(): void
    {
        $inputData = new InputData('company', '', validationErrors: ['Value cannot be blank.']);

        $result = Text::widget()
            ->inputInvalidClass('invalid')
            ->inputValidClass('valid')
            ->inputData($inputData)
            ->render();

        $expected = <<<HTML
            <div>
            <input type="text" class="invalid" name="company" value>
            <div>Value cannot be blank.</div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testInputValidClass(): void
    {
        $inputData = new InputData(
            name: 'job',
            value: '',
            validationErrors: [],
        );

        $result = Text::widget()
            ->inputInvalidClass('invalid')
            ->inputValidClass('valid')
            ->inputData($inputData)
            ->render();

        $expected = <<<HTML
            <div>
            <input type="text" class="valid" name="job" value>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testInvalidClassesWithCustomError(): void
    {
        $inputData = new InputData('company', '');

        $result = Text::widget()
            ->invalidClass('invalidWrap')
            ->inputValidClass('validWrap')
            ->inputInvalidClass('invalid')
            ->inputValidClass('valid')
            ->inputData($inputData)
            ->error('Value cannot be blank.')
            ->render();

        $expected = <<<HTML
            <div class="invalidWrap">
            <input type="text" class="invalid" name="company" value>
            <div>Value cannot be blank.</div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testImmutability(): void
    {
        $field = Text::widget();

        $this->assertNotSame($field, $field->maxlength(null));
        $this->assertNotSame($field, $field->minlength(null));
        $this->assertNotSame($field, $field->dirname(null));
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
