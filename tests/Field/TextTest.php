<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field\Base\InputData\FormModelInputData;
use Yiisoft\Form\Field\Base\InputData\PureInputData;
use Yiisoft\Form\Field\Text;
use Yiisoft\Form\Tests\Support\Form\TextForm;
use Yiisoft\Form\ThemeContainer;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class TextTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer());
        ThemeContainer::initialize(
            validationRulesEnrichmenters: [
                FormModelInputData::class => dirname(__DIR__, 2) . '/src/yii-validator-rules-enrichmenter.php',
            ],
        );
    }

    public function testBase(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="textform-name">Name</label>
        <input type="text" id="textform-name" name="TextForm[name]" value placeholder="Typed your name here">
        <div>Input your full name.</div>
        <div>Value cannot be blank.</div>
        </div>
        HTML;

        $result = Text::widget()
            ->inputData(new FormModelInputData(TextForm::validated(), 'name'))
            ->render();

        $this->assertSame($expected, $result);
    }

    public function testEmpty(): void
    {
        $expected = <<<HTML
        <div>
        <input type="text">
        </div>
        HTML;

        $result = Text::widget()->render();

        $this->assertSame($expected, $result);
    }

    public function testCustomName(): void
    {
        $expected = <<<HTML
        <div>
        <input type="text" name="the-name">
        </div>
        HTML;

        $result = Text::widget()->name('the-name')->render();

        $this->assertSame($expected, $result);
    }

    public function testCustomNameAfterInputData(): void
    {
        $expected = <<<HTML
        <div>
        <label for="textform-name">Name</label>
        <input type="text" id="textform-name" name="the-name" value placeholder="Typed your name here">
        <div>Input your full name.</div>
        <div>Value cannot be blank.</div>
        </div>
        HTML;

        $result = Text::widget()
            ->inputData(new FormModelInputData(TextForm::validated(), 'name'))
            ->name('the-name')
            ->render();

        $this->assertSame($expected, $result);
    }

    public function testCustomNameBeforeInputData(): void
    {
        $expected = <<<HTML
        <div>
        <label for="textform-name">Name</label>
        <input type="text" id="textform-name" name="TextForm[name]" value placeholder="Typed your name here">
        <div>Input your full name.</div>
        <div>Value cannot be blank.</div>
        </div>
        HTML;

        $result = Text::widget()
            ->name('the-name')
            ->inputData(new FormModelInputData(TextForm::validated(), 'name'))
            ->render();

        $this->assertSame($expected, $result);
    }

    public function testCustomValueAfterInputData(): void
    {
        $expected = <<<HTML
        <div>
        <label for="textform-name">Name</label>
        <input type="text" id="textform-name" name="TextForm[name]" value="42" placeholder="Typed your name here">
        <div>Input your full name.</div>
        <div>Value cannot be blank.</div>
        </div>
        HTML;

        $result = Text::widget()
            ->inputData(new FormModelInputData(TextForm::validated(), 'name'))
            ->value('42')
            ->render();

        $this->assertSame($expected, $result);
    }

    public function testCustomValueBeforeInputData(): void
    {
        $expected = <<<HTML
        <div>
        <label for="textform-name">Name</label>
        <input type="text" id="textform-name" name="TextForm[name]" value placeholder="Typed your name here">
        <div>Input your full name.</div>
        <div>Value cannot be blank.</div>
        </div>
        HTML;

        $result = Text::widget()
            ->value('42')
            ->inputData(new FormModelInputData(TextForm::validated(), 'name'))
            ->render();

        $this->assertSame($expected, $result);
    }

    public function testInvalidValue(): void
    {
        $widget = Text::widget()
            ->inputData(new FormModelInputData(new TextForm(), 'age'));

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Text field requires a string or null value.');
        $widget->render();
    }

    public function testWithoutContainer(): void
    {
        $expected = <<<'HTML'
        <label for="textform-job">Job</label>
        <input type="text" id="textform-job" name="TextForm[job]" value>
        HTML;

        $result = Text::widget()
            ->inputData(new FormModelInputData(TextForm::validated(), 'job'))
            ->useContainer(false)
            ->render();

        $this->assertSame($expected, $result);
    }

    public function testCustomContainerTag(): void
    {
        $expected = <<<'HTML'
        <section>
        <label for="textform-job">Job</label>
        <input type="text" id="textform-job" name="TextForm[job]" value>
        </section>
        HTML;

        $result = Text::widget()
            ->inputData(new FormModelInputData(TextForm::validated(), 'job'))
            ->containerTag('section')
            ->render();

        $this->assertSame($expected, $result);
    }

    public function testEmptyContainerTag(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Tag name cannot be empty.');
        Text::widget()
            ->inputData(new PureInputData())
            ->containerTag('');
    }

    public function testContainerAttributes(): void
    {
        $expected = <<<'HTML'
        <div id="main" class="wrapper">
        <label for="textform-job">Job</label>
        <input type="text" id="textform-job" name="TextForm[job]" value>
        </div>
        HTML;

        $result = Text::widget()
            ->inputData(new FormModelInputData(TextForm::validated(), 'job'))
            ->containerAttributes(['class' => 'wrapper', 'id' => 'main'])
            ->render();

        $this->assertSame($expected, $result);
    }

    public function testCustomTemplate(): void
    {
        $expected = <<<'HTML'
        <div>
        <div class="wrap">
        <div>Input your full name.</div>
        <label for="textform-name">Name</label>
        <div>Value cannot be blank.</div>
        <input type="text" id="textform-name" name="TextForm[name]" value placeholder="Typed your name here">
        </div>
        </div>
        HTML;

        $result = Text::widget()
            ->inputData(new FormModelInputData(TextForm::validated(), 'name'))
            ->template("<div class=\"wrap\">\n{hint}\n{label}\n{error}\n{input}\n</div>")
            ->render();

        $this->assertSame($expected, $result);
    }

    public function testCustomInputId(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="CustomID">Job</label>
        <input type="text" id="CustomID" name="TextForm[job]" value>
        </div>
        HTML;

        $result = Text::widget()
            ->inputData(new FormModelInputData(TextForm::validated(), 'job'))
            ->inputId('CustomID')
            ->render();

        $this->assertSame($expected, $result);
    }

    public function testDoNotSetInputId(): void
    {
        $expected = <<<'HTML'
        <div>
        <label>Job</label>
        <input type="text" name="TextForm[job]" value>
        </div>
        HTML;

        $result = Text::widget()
            ->inputData(new FormModelInputData(TextForm::validated(), 'job'))
            ->setInputId(false)
            ->render();

        $this->assertSame($expected, $result);
    }

    public function testCustomLabelConfig(): void
    {
        $expected = <<<'HTML'
        <div>
        <label>Your job</label>
        <input type="text" id="textform-job" name="TextForm[job]" value>
        </div>
        HTML;

        $result = Text::widget()
            ->inputData(new FormModelInputData(TextForm::validated(), 'job'))
            ->labelConfig([
                'setFor()' => [false],
                'content()' => ['Your job'],
            ])
            ->render();

        $this->assertSame($expected, $result);
    }

    public function testCustomLabel(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="textform-job">Your job</label>
        <input type="text" id="textform-job" name="TextForm[job]" value>
        </div>
        HTML;

        $result = Text::widget()
            ->inputData(new FormModelInputData(TextForm::validated(), 'job'))
            ->label('Your job')
            ->render();

        $this->assertSame($expected, $result);
    }

    public function testCustomHintConfig(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="textform-name">Name</label>
        <input type="text" id="textform-name" name="TextForm[name]" value placeholder="Typed your name here">
        <b class="red">Input your full name.</b>
        </div>
        HTML;

        $result = Text::widget()
            ->inputData(new FormModelInputData(new TextForm(), 'name'))
            ->hintConfig([
                'tag()' => ['b'],
                'attributes()' => [['class' => 'red']],
            ])
            ->render();

        $this->assertSame($expected, $result);
    }

    public function testCustomHint(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="textform-name">Name</label>
        <input type="text" id="textform-name" name="TextForm[name]" value placeholder="Typed your name here">
        <div>Custom hint.</div>
        </div>
        HTML;

        $result = Text::widget()
            ->inputData(new FormModelInputData(new TextForm(), 'name'))
            ->hint('Custom hint.')
            ->render();

        $this->assertSame($expected, $result);
    }

    public function testCustomErrorConfig(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="textform-name">Name</label>
        <input type="text" id="textform-name" name="TextForm[name]" value placeholder="Typed your name here">
        <div>Input your full name.</div>
        <b class="red">Value cannot be blank.</b>
        </div>
        HTML;

        $result = Text::widget()
            ->inputData(new FormModelInputData(TextForm::validated(), 'name'))
            ->errorConfig([
                'tag()' => ['b'],
                'attributes()' => [['class' => 'red']],
            ])
            ->render();

        $this->assertSame($expected, $result);
    }

    public function testOverridePlaceholder(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="textform-name">Name</label>
        <input type="text" id="textform-name" name="TextForm[name]" value placeholder="Input your pretty name">
        <div>Input your full name.</div>
        <div>Value cannot be blank.</div>
        </div>
        HTML;

        $result = Text::widget()
            ->inputData(new FormModelInputData(TextForm::validated(), 'name'))
            ->placeholder('Input your pretty name')
            ->render();

        $this->assertSame($expected, $result);
    }

    public function testDoNotSetPlaceholder(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="textform-name">Name</label>
        <input type="text" id="textform-name" name="TextForm[name]" value>
        <div>Input your full name.</div>
        <div>Value cannot be blank.</div>
        </div>
        HTML;

        $result = Text::widget()
            ->inputData(new FormModelInputData(TextForm::validated(), 'name'))
            ->usePlaceholder(false)
            ->render();

        $this->assertSame($expected, $result);
    }

    public function testAddInputAttributes(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="textform-job">Job</label>
        <input type="text" id="textform-job" class="red" name="TextForm[job]" value>
        </div>
        HTML;

        $result = Text::widget()
            ->inputData(new FormModelInputData(TextForm::validated(), 'job'))
            ->addInputAttributes(['class' => 'red'])
            ->render();

        $this->assertSame($expected, $result);
    }

    public function testInputAttributesOverridePlaceholderFromForm(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="textform-name">Name</label>
        <input type="text" id="textform-name" name="TextForm[name]" value placeholder="Input your pretty name">
        <div>Input your full name.</div>
        <div>Value cannot be blank.</div>
        </div>
        HTML;

        $result = Text::widget()
            ->inputData(new FormModelInputData(TextForm::validated(), 'name'))
            ->inputAttributes(['placeholder' => 'Input your pretty name'])
            ->render();

        $this->assertSame($expected, $result);
    }

    public function testInputAttributesOverrideIdFromForm(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="MyID">Name</label>
        <input type="text" id="MyID" name="TextForm[name]" value placeholder="Typed your name here">
        <div>Input your full name.</div>
        <div>Value cannot be blank.</div>
        </div>
        HTML;

        $result = Text::widget()
            ->inputData(new FormModelInputData(TextForm::validated(), 'name'))
            ->inputAttributes(['id' => 'MyID'])
            ->render();

        $this->assertSame($expected, $result);
    }

    public function testInputIdOverrideIdFromAttributes(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="CustomID">Name</label>
        <input type="text" id="CustomID" name="TextForm[name]" value placeholder="Typed your name here">
        <div>Input your full name.</div>
        <div>Value cannot be blank.</div>
        </div>
        HTML;

        $result = Text::widget()
            ->inputData(new FormModelInputData(TextForm::validated(), 'name'))
            ->inputId('CustomID')
            ->inputAttributes(['id' => 'MyID'])
            ->render();

        $this->assertSame($expected, $result);
    }

    public function testDirname(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="textform-job">Job</label>
        <input type="text" id="textform-job" name="TextForm[job]" value dirname="test">
        </div>
        HTML;

        $result = Text::widget()
            ->inputData(new FormModelInputData(new TextForm(), 'job'))
            ->dirname('test')
            ->render();

        $this->assertSame($expected, $result);
    }

    public function testMaxlength(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="textform-job">Job</label>
        <input type="text" id="textform-job" name="TextForm[job]" value maxlength="5">
        </div>
        HTML;

        $result = Text::widget()
            ->inputData(new FormModelInputData(new TextForm(), 'job'))
            ->maxlength(5)
            ->render();

        $this->assertSame($expected, $result);
    }

    public function testMinlength(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="textform-job">Job</label>
        <input type="text" id="textform-job" name="TextForm[job]" value minlength="5">
        </div>
        HTML;

        $result = Text::widget()
            ->inputData(new FormModelInputData(new TextForm(), 'job'))
            ->minlength(5)
            ->render();

        $this->assertSame($expected, $result);
    }

    public function testPattern(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="textform-job">Job</label>
        <input type="text" id="textform-job" name="TextForm[job]" value pattern="[0-9]{3}">
        </div>
        HTML;

        $result = Text::widget()
            ->inputData(new FormModelInputData(new TextForm(), 'job'))
            ->pattern('[0-9]{3}')
            ->render();

        $this->assertSame($expected, $result);
    }

    public function testSize(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="textform-job">Job</label>
        <input type="text" id="textform-job" name="TextForm[job]" value size="12">
        </div>
        HTML;

        $result = Text::widget()
            ->inputData(new FormModelInputData(new TextForm(), 'job'))
            ->size(12)
            ->render();

        $this->assertSame($expected, $result);
    }

    public function testReadonly(): void
    {
        $result = Text::widget()
            ->inputData(new FormModelInputData(new TextForm(), 'job'))
            ->useContainer(false)
            ->hideLabel()
            ->readonly()
            ->render();

        $this->assertSame(
            '<input type="text" id="textform-job" name="TextForm[job]" value readonly>',
            $result
        );
    }

    public function testRequired(): void
    {
        $result = Text::widget()
            ->inputData(new FormModelInputData(new TextForm(), 'job'))
            ->useContainer(false)
            ->hideLabel()
            ->required()
            ->render();

        $this->assertSame(
            '<input type="text" id="textform-job" name="TextForm[job]" value required>',
            $result
        );
    }

    public function testDisabled(): void
    {
        $result = Text::widget()
            ->inputData(new FormModelInputData(new TextForm(), 'job'))
            ->useContainer(false)
            ->hideLabel()
            ->disabled()
            ->render();

        $this->assertSame(
            '<input type="text" id="textform-job" name="TextForm[job]" value disabled>',
            $result
        );
    }

    public function testAriaDescribedBy(): void
    {
        $result = Text::widget()
            ->inputData(new FormModelInputData(new TextForm(), 'job'))
            ->useContainer(false)
            ->hideLabel()
            ->ariaDescribedBy('hint')
            ->render();

        $this->assertSame(
            '<input type="text" id="textform-job" name="TextForm[job]" value aria-describedby="hint">',
            $result
        );
    }

    public function testAriaLabel(): void
    {
        $result = Text::widget()
            ->inputData(new FormModelInputData(new TextForm(), 'job'))
            ->useContainer(false)
            ->hideLabel()
            ->ariaLabel('test')
            ->render();

        $this->assertSame(
            '<input type="text" id="textform-job" name="TextForm[job]" value aria-label="test">',
            $result
        );
    }

    public function testAutofocus(): void
    {
        $result = Text::widget()
            ->inputData(new FormModelInputData(new TextForm(), 'job'))
            ->useContainer(false)
            ->hideLabel()
            ->autofocus()
            ->render();

        $this->assertSame(
            '<input type="text" id="textform-job" name="TextForm[job]" value autofocus>',
            $result
        );
    }

    public function testTabIndex(): void
    {
        $result = Text::widget()
            ->inputData(new FormModelInputData(new TextForm(), 'job'))
            ->useContainer(false)
            ->hideLabel()
            ->tabIndex(5)
            ->render();

        $this->assertSame(
            '<input type="text" id="textform-job" name="TextForm[job]" value tabindex="5">',
            $result
        );
    }

    public function testValidationClassForNonValidatedForm(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="textform-job">Job</label>
        <input type="text" id="textform-job" name="TextForm[job]" value>
        </div>
        HTML;

        $result = Text::widget()
            ->invalidClass('invalid')
            ->validClass('valid')
            ->inputData(new FormModelInputData(new TextForm(), 'job'))
            ->render();

        $this->assertSame($expected, $result);
    }

    public function testInvalidClass(): void
    {
        $expected = <<<'HTML'
        <div class="invalid">
        <label for="textform-company">Company</label>
        <input type="text" id="textform-company" name="TextForm[company]" value>
        <div>Value cannot be blank.</div>
        </div>
        HTML;

        $result = Text::widget()
            ->invalidClass('invalid')
            ->validClass('valid')
            ->inputData(new FormModelInputData(TextForm::validated(), 'company'))
            ->render();

        $this->assertSame($expected, $result);
    }

    public function testValidClass(): void
    {
        $expected = <<<'HTML'
        <div class="valid">
        <label for="textform-job">Job</label>
        <input type="text" id="textform-job" name="TextForm[job]" value>
        </div>
        HTML;

        $result = Text::widget()
            ->invalidClass('invalid')
            ->validClass('valid')
            ->inputData(new FormModelInputData(TextForm::validated(), 'job'))
            ->render();

        $this->assertSame($expected, $result);
    }

    public function testInputInvalidClass(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="textform-company">Company</label>
        <input type="text" id="textform-company" class="invalid" name="TextForm[company]" value>
        <div>Value cannot be blank.</div>
        </div>
        HTML;

        $result = Text::widget()
            ->inputInvalidClass('invalid')
            ->inputValidClass('valid')
            ->inputData(new FormModelInputData(TextForm::validated(), 'company'))
            ->render();

        $this->assertSame($expected, $result);
    }

    public function testInputValidClass(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="textform-job">Job</label>
        <input type="text" id="textform-job" class="valid" name="TextForm[job]" value>
        </div>
        HTML;

        $result = Text::widget()
            ->inputInvalidClass('invalid')
            ->inputValidClass('valid')
            ->inputData(new FormModelInputData(TextForm::validated(), 'job'))
            ->render();

        $this->assertSame($expected, $result);
    }

    public function dataEnrichmentFromRules(): array
    {
        return [
            'required' => [
                '<input type="text" id="textform-company" name="TextForm[company]" value required>',
                'company',
            ],
            'has-length' => [
                '<input type="text" id="textform-shortdesc" name="TextForm[shortdesc]" value maxlength="199" minlength="10">',
                'shortdesc',
            ],
            'regex' => [
                '<input type="text" id="textform-code" name="TextForm[code]" value pattern="\w+">',
                'code',
            ],
            'regex-not' => [
                '<input type="text" id="textform-nocode" name="TextForm[nocode]" value>',
                'nocode',
            ],
            'required-with-when' => [
                '<input type="text" id="textform-requiredwhen" name="TextForm[requiredWhen]">',
                'requiredWhen',
            ],
        ];
    }

    /**
     * @dataProvider dataEnrichmentFromRules
     */
    public function testEnrichmentFromRules(string $expected, string $attribute): void
    {
        $field = Text::widget()
            ->inputData(new FormModelInputData(new TextForm(), $attribute))
            ->hideLabel()
            ->enrichmentFromRules(true)
            ->useContainer(false);

        $this->assertSame($expected, $field->render());
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
