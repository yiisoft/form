<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field\InputText;
use Yiisoft\Form\Tests\TestSupport\AssertTrait;
use Yiisoft\Form\Tests\TestSupport\Form\TypeForm;
use Yiisoft\Html\Tag\CustomTag;
use Yiisoft\Html\Tag\Div;
use Yiisoft\Html\Tag\Input;
use Yiisoft\Widget\WidgetFactory;

final class InputTextTest extends TestCase
{
    use AssertTrait;

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize();
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
            ->doNotSetInputIdAttribute()
            ->render();

        $this->assertStringContainsStringIgnoringLineEndings($expected, $result);
    }
}
