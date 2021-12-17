<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field\InputText;
use Yiisoft\Form\Tests\Support\AssertTrait;
use Yiisoft\Form\Tests\TestSupport\Form\PersonalForm;
use Yiisoft\Form\Tests\TestSupport\Form\TypeForm;
use Yiisoft\Form\Tests\TestSupport\Validator\ValidatorMock;
use Yiisoft\Html\Tag\CustomTag;
use Yiisoft\Html\Tag\Input;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class InputTextTest extends TestCase
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
        <label for="typeform-string">String</label>
        <input type="text" id="typeform-string" name="TypeForm[string]" value placeholder="Typed your text string.">
        <div>Write your text string.</div>
        </div>
        HTML;

        $result = InputText::widget()
            ->attribute(new TypeForm(), 'string')
            ->render();

        $this->assertStringContainsStringIgnoringLineEndings($expected, $result);
    }

    public function testWithoutContainer(): void
    {
        $expected = <<<'HTML'
        <label for="typeform-string">String</label>
        <input type="text" id="typeform-string" name="TypeForm[string]" value placeholder="Typed your text string.">
        <div>Write your text string.</div>
        HTML;

        $result = InputText::widget()
            ->attribute(new TypeForm(), 'string')
            ->withoutContainer()
            ->render();

        $this->assertStringContainsStringIgnoringLineEndings($expected, $result);
    }

    public function testCustomContainer(): void
    {
        $expected = <<<'HTML'
        <section class="wrapper">
        <label for="typeform-string">String</label>
        <input type="text" id="typeform-string" name="TypeForm[string]" value placeholder="Typed your text string.">
        <div>Write your text string.</div>
        </section>
        HTML;

        $result = InputText::widget()
            ->attribute(new TypeForm(), 'string')
            ->containerTag(CustomTag::name('section')->class('wrapper'))
            ->render();

        $this->assertStringContainsStringIgnoringLineEndings($expected, $result);
    }

    public function testInputTag(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-string">String</label>
        <input type="text" id="typeform-string" class="big" name="TypeForm[string]" value placeholder="Typed your text string.">
        <div>Write your text string.</div>
        </div>
        HTML;

        $result = InputText::widget()
            ->attribute(new TypeForm(), 'string')
            ->inputTag(Input::text()->class('big'))
            ->render();

        $this->assertStringContainsStringIgnoringLineEndings($expected, $result);
    }

    public function testInputNotTextTag(): void
    {
        $widget = InputText::widget()->attribute(new TypeForm(), 'string');
        $tag = Input::hidden()->class('big');

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Input tag should be with type "text".');
        $widget->inputTag($tag);
    }

    public function testDoNotSetInputIdAttribute(): void
    {
        $expected = <<<'HTML'
        <div>
        <label>String</label>
        <input type="text" name="TypeForm[string]" value placeholder="Typed your text string.">
        <div>Write your text string.</div>
        </div>
        HTML;

        $result = InputText::widget()
            ->attribute(new TypeForm(), 'string')
            ->setInputIdAttribute(false)
            ->render();

        $this->assertStringContainsStringIgnoringLineEndings($expected, $result);
    }

    public function testHint(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-string">String</label>
        <input type="text" id="typeform-string" name="TypeForm[string]" value placeholder="Typed your text string.">
        <div>Modified hint.</div>
        </div>
        HTML;

        $result = InputText::widget()
            ->attribute(new TypeForm(), 'string')
            ->hint('Modified hint.')
            ->render();

        $this->assertStringContainsStringIgnoringLineEndings($expected, $result);
    }

    public function testHintConfig(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-string">String</label>
        <input type="text" id="typeform-string" name="TypeForm[string]" value placeholder="Typed your text string.">
        <div class="red">Write your text string.</div>
        </div>
        HTML;

        $result = InputText::widget()
            ->attribute(new TypeForm(), 'string')
            ->hintConfig([
                'tagAttributes()' => [['class' => 'red']],
            ])
            ->render();

        $this->assertStringContainsStringIgnoringLineEndings($expected, $result);
    }

    public function testError(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="personalform-name">Name</label>
        <input type="text" id="personalform-name" name="PersonalForm[name]" value placeholder>
        <div>Write your first name.</div>
        <div>Value cannot be blank.</div>
        </div>
        HTML;

        $form = new PersonalForm();
        (new ValidatorMock())->validate($form);

        $result = InputText::widget()
            ->attribute($form, 'name')
            ->render();

        $this->assertStringContainsStringIgnoringLineEndings($expected, $result);
    }
}
