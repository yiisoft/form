<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field\Text;
use Yiisoft\Form\Tests\Support\AssertTrait;
use Yiisoft\Form\Tests\Support\Form\TextForm;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class TextTest extends TestCase
{
    use AssertTrait;

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer());
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
            ->attribute(TextForm::validated(), 'name')
            ->render();

        $this->assertStringContainsStringIgnoringLineEndings($expected, $result);
    }

    public function testInvalidValue(): void
    {
        $widget = Text::widget()
            ->attribute(new TextForm(), 'age');

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Text widget must be a string or null value.');
        $widget->render();
    }

    public function testWithoutContainer(): void
    {
        $expected = <<<'HTML'
        <label for="textform-job">Job</label>
        <input type="text" id="textform-job" name="TextForm[job]" value>
        HTML;

        $result = Text::widget()
            ->attribute(TextForm::validated(), 'job')
            ->useContainer(false)
            ->render();

        $this->assertStringContainsStringIgnoringLineEndings($expected, $result);
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
            ->attribute(TextForm::validated(), 'job')
            ->containerTag('section')
            ->render();

        $this->assertStringContainsStringIgnoringLineEndings($expected, $result);
    }

    public function testEmptyContainerTag(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Tag name cannot be empty.');
        Text::widget()
            ->attribute(TextForm::validated(), 'job')
            ->containerTag('');
    }

    public function testContainerTagAttributes(): void
    {
        $expected = <<<'HTML'
        <div id="main" class="wrapper">
        <label for="textform-job">Job</label>
        <input type="text" id="textform-job" name="TextForm[job]" value>
        </div>
        HTML;

        $result = Text::widget()
            ->attribute(TextForm::validated(), 'job')
            ->containerTagAttributes(['class' => 'wrapper', 'id' => 'main'])
            ->render();

        $this->assertStringContainsStringIgnoringLineEndings($expected, $result);
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
            ->attribute(TextForm::validated(), 'name')
            ->template("<div class=\"wrap\">\n{hint}\n{label}\n{error}\n{input}\n</div>")
            ->render();

        $this->assertStringContainsStringIgnoringLineEndings($expected, $result);
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
            ->attribute(TextForm::validated(), 'job')
            ->inputId('CustomID')
            ->render();

        $this->assertStringContainsStringIgnoringLineEndings($expected, $result);
    }

    public function testDoNotSetInputIdAttribute(): void
    {
        $expected = <<<'HTML'
        <div>
        <label>Job</label>
        <input type="text" name="TextForm[job]" value>
        </div>
        HTML;

        $result = Text::widget()
            ->attribute(TextForm::validated(), 'job')
            ->setInputIdAttribute(false)
            ->render();

        $this->assertStringContainsStringIgnoringLineEndings($expected, $result);
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
            ->attribute(TextForm::validated(), 'job')
            ->labelConfig([
                'setForAttribute()' => [false],
                'content()' => ['Your job'],
            ])
            ->render();

        $this->assertStringContainsStringIgnoringLineEndings($expected, $result);
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
            ->attribute(TextForm::validated(), 'job')
            ->label('Your job')
            ->render();

        $this->assertStringContainsStringIgnoringLineEndings($expected, $result);
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
            ->attribute(new TextForm(), 'name')
            ->hintConfig([
                'tag()' => ['b'],
                'tagAttributes()' => [['class' => 'red']],
            ])
            ->render();

        $this->assertStringContainsStringIgnoringLineEndings($expected, $result);
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
            ->attribute(new TextForm(), 'name')
            ->hint('Custom hint.')
            ->render();

        $this->assertStringContainsStringIgnoringLineEndings($expected, $result);
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
            ->attribute(TextForm::validated(), 'name')
            ->errorConfig([
                'tag()' => ['b'],
                'tagAttributes()' => [['class' => 'red']],
            ])
            ->render();

        $this->assertStringContainsStringIgnoringLineEndings($expected, $result);
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
            ->attribute(TextForm::validated(), 'name')
            ->placeholder('Input your pretty name')
            ->render();

        $this->assertStringContainsStringIgnoringLineEndings($expected, $result);
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
            ->attribute(TextForm::validated(), 'name')
            ->usePlaceholder(false)
            ->render();

        $this->assertStringContainsStringIgnoringLineEndings($expected, $result);
    }

    public function testInputTagAttributes(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="textform-job">Job</label>
        <input type="text" id="textform-job" class="red" name="TextForm[job]" value>
        </div>
        HTML;

        $result = Text::widget()
            ->attribute(TextForm::validated(), 'job')
            ->inputTagAttributes(['class' => 'red'])
            ->render();

        $this->assertStringContainsStringIgnoringLineEndings($expected, $result);
    }

    public function testInputTagAttributesOverridePlaceholderFromForm(): void
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
            ->attribute(TextForm::validated(), 'name')
            ->inputTagAttributes(['placeholder' => 'Input your pretty name'])
            ->render();

        $this->assertStringContainsStringIgnoringLineEndings($expected, $result);
    }

    public function testInputTagAttributesOverrideIdFromForm(): void
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
            ->attribute(TextForm::validated(), 'name')
            ->inputTagAttributes(['id' => 'MyID'])
            ->render();

        $this->assertStringContainsStringIgnoringLineEndings($expected, $result);
    }

    public function testInputIdOverrideIdFromTagAttributes(): void
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
            ->attribute(TextForm::validated(), 'name')
            ->inputId('CustomID')
            ->inputTagAttributes(['id' => 'MyID'])
            ->render();

        $this->assertStringContainsStringIgnoringLineEndings($expected, $result);
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
            ->attribute(new TextForm(), 'job')
            ->dirname('test')
            ->render();

        $this->assertStringContainsStringIgnoringLineEndings($expected, $result);
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
            ->attribute(new TextForm(), 'job')
            ->maxlength(5)
            ->render();

        $this->assertStringContainsStringIgnoringLineEndings($expected, $result);
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
            ->attribute(new TextForm(), 'job')
            ->minlength(5)
            ->render();

        $this->assertStringContainsStringIgnoringLineEndings($expected, $result);
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
            ->attribute(new TextForm(), 'job')
            ->pattern('[0-9]{3}')
            ->render();

        $this->assertStringContainsStringIgnoringLineEndings($expected, $result);
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
            ->attribute(new TextForm(), 'job')
            ->size(12)
            ->render();

        $this->assertStringContainsStringIgnoringLineEndings($expected, $result);
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
            ->attribute(new TextForm(), 'job')
            ->render();

        $this->assertStringEqualsStringIgnoringLineEndings($expected, $result);
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
            ->attribute(TextForm::validated(), 'company')
            ->render();

        $this->assertStringEqualsStringIgnoringLineEndings($expected, $result);
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
            ->attribute(TextForm::validated(), 'job')
            ->render();

        $this->assertStringEqualsStringIgnoringLineEndings($expected, $result);
    }

    public function dataEnrichmentFromRules(): array
    {
        return [
            'required' => [
                '<input type="text" id="textform-company" name="TextForm[company]" value required>',
                'company'
            ],
            'has-length' => [
                '<input type="text" id="textform-shortdesc" name="TextForm[shortdesc]" value maxlength="199" minlength="10">',
                'shortdesc'
            ],
            'regex' => [
                '<input type="text" id="textform-code" name="TextForm[code]" value pattern="\w+">',
                'code'
            ],
            'regex-not' => [
                '<input type="text" id="textform-nocode" name="TextForm[nocode]" value>',
                'nocode'
            ],
        ];
    }

    /**
     * @dataProvider dataEnrichmentFromRules
     */
    public function testEnrichmentFromRules(string $expected, string $attribute): void
    {
        $field = Text::widget()
            ->attribute(new TextForm(), $attribute)
            ->hideLabel()
            ->enrichmentFromRules(true)
            ->useContainer(false);

        $this->assertSame($expected, $field->render());
    }

    public function testImmutability(): void
    {
        $field = Text::widget();

        $this->assertNotSame($field, $field->dirname('test'));
        $this->assertNotSame($field, $field->maxlength(6));
        $this->assertNotSame($field, $field->minlength(2));
        $this->assertNotSame($field, $field->pattern('[a-z]'));
        $this->assertNotSame($field, $field->size(5));
    }
}
