<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field\Base;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use stdClass;
use Yiisoft\Form\Tests\Support\StubPartsField;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class PartsFieldTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer());
    }

    public function testBase(): void
    {
        $result = StubPartsField::widget()
            ->tokens([
                '{before}' => '<section>',
                '{after}' => '</section>',
            ])
            ->token('{icon}', '<span class="icon"></span>')
            ->template("{before}\n{input}\n{icon}\n{after}")
            ->render();

        $expected = <<<HTML
            <div>
            <section>
            <span class="icon"></span>
            </section>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testBeginEnd(): void
    {
        $field = StubPartsField::widget()
            ->tokens([
                '{before}' => '<section>',
                '{after}' => '</section>',
            ])
            ->token('{icon}', '<span class="icon"></span>')
            ->templateBegin("{before}\n{input}")
            ->templateEnd("{input}\n{icon}\n{after}");

        $result = $field->begin() . "\n" . $field::end();

        $expected = <<<HTML
            <div>
            <section>
            <span class="icon"></span>
            </section>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testBuiltinToken(): void
    {
        $field = StubPartsField::widget();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Token name "{hint}" is built-in.');
        $field->token('{hint}', 'hello');
    }

    public function testEmptyToken(): void
    {
        $field = StubPartsField::widget();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Token must be non-empty string.');
        $field->token('', 'hello');
    }

    public function testNonStringTokenName(): void
    {
        $field = StubPartsField::widget();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Token should be string. 0 given.');
        $field->tokens(['hello']);
    }

    public function testNonStringTokenValue(): void
    {
        $field = StubPartsField::widget();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Token value should be string or Stringable. stdClass given.');
        $field->tokens(['{before}' => new stdClass()]);
    }

    public function testLabelAttributes(): void
    {
        $result = StubPartsField::widget()
            ->label('test')
            ->labelAttributes(['class' => 'red'])
            ->labelAttributes(['id' => 'KEY'])
            ->render();

        $expected = <<<HTML
            <div>
            <label id="KEY" class="red">test</label>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testReplaceLabelAttributes(): void
    {
        $result = StubPartsField::widget()
            ->label('test')
            ->labelAttributes(['class' => 'red'])
            ->replaceLabelAttributes(['id' => 'KEY'])
            ->render();

        $expected = <<<HTML
            <div>
            <label id="KEY">test</label>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testLabelId(): void
    {
        $result = StubPartsField::widget()
            ->label('test')
            ->labelId('KEY')
            ->render();

        $expected = <<<HTML
            <div>
            <label id="KEY">test</label>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testLabelClass(): void
    {
        $result = StubPartsField::widget()
            ->label('test')
            ->labelClass('red')
            ->labelClass('blue')
            ->render();

        $expected = <<<HTML
            <div>
            <label class="red blue">test</label>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testReplaceLabelClass(): void
    {
        $result = StubPartsField::widget()
            ->label('test')
            ->labelClass('red')
            ->replaceLabelClass('blue')
            ->render();

        $expected = <<<HTML
            <div>
            <label class="blue">test</label>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testHintAttributes(): void
    {
        $result = StubPartsField::widget()
            ->hint('test')
            ->hintAttributes(['class' => 'red'])
            ->hintAttributes(['id' => 'KEY'])
            ->render();

        $expected = <<<HTML
            <div>
            <div id="KEY" class="red">test</div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testReplaceHintAttributes(): void
    {
        $result = StubPartsField::widget()
            ->hint('test')
            ->hintAttributes(['class' => 'red'])
            ->replaceHintAttributes(['id' => 'KEY'])
            ->render();

        $expected = <<<HTML
            <div>
            <div id="KEY">test</div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testHintId(): void
    {
        $result = StubPartsField::widget()
            ->hint('test')
            ->hintId('KEY')
            ->render();

        $expected = <<<HTML
            <div>
            <div id="KEY">test</div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testHintClass(): void
    {
        $result = StubPartsField::widget()
            ->hint('test')
            ->hintClass('red')
            ->hintClass('blue')
            ->render();

        $expected = <<<HTML
            <div>
            <div class="red blue">test</div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testReplaceHintClass(): void
    {
        $result = StubPartsField::widget()
            ->hint('test')
            ->hintClass('red')
            ->replaceHintClass('blue')
            ->render();

        $expected = <<<HTML
            <div>
            <div class="blue">test</div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testErrorAttributes(): void
    {
        $result = StubPartsField::widget()
            ->error('test')
            ->errorAttributes(['class' => 'red'])
            ->errorAttributes(['id' => 'KEY'])
            ->render();

        $expected = <<<HTML
            <div>
            <div id="KEY" class="red">test</div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testReplaceErrorAttributes(): void
    {
        $result = StubPartsField::widget()
            ->error('test')
            ->errorAttributes(['class' => 'red'])
            ->replaceErrorAttributes(['id' => 'KEY'])
            ->render();

        $expected = <<<HTML
            <div>
            <div id="KEY">test</div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testErrorId(): void
    {
        $result = StubPartsField::widget()
            ->error('test')
            ->errorId('KEY')
            ->render();

        $expected = <<<HTML
            <div>
            <div id="KEY">test</div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testErrorClass(): void
    {
        $result = StubPartsField::widget()
            ->error('test')
            ->errorClass('red')
            ->errorClass('blue')
            ->render();

        $expected = <<<HTML
            <div>
            <div class="red blue">test</div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testReplaceErrorClass(): void
    {
        $result = StubPartsField::widget()
            ->error('test')
            ->errorClass('red')
            ->replaceErrorClass('blue')
            ->render();

        $expected = <<<HTML
            <div>
            <div class="blue">test</div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testImmutability(): void
    {
        $field = StubPartsField::widget();

        $this->assertNotSame($field, $field->tokens([]));
        $this->assertNotSame($field, $field->token('{before}', ''));
        $this->assertNotSame($field, $field->template(''));
        $this->assertNotSame($field, $field->hideLabel());
        $this->assertNotSame($field, $field->labelConfig([]));
        $this->assertNotSame($field, $field->labelAttributes([]));
        $this->assertNotSame($field, $field->replaceLabelAttributes([]));
        $this->assertNotSame($field, $field->labelId(null));
        $this->assertNotSame($field, $field->labelClass());
        $this->assertNotSame($field, $field->replaceLabelClass());
        $this->assertNotSame($field, $field->label(null));
        $this->assertNotSame($field, $field->hintConfig([]));
        $this->assertNotSame($field, $field->hintAttributes([]));
        $this->assertNotSame($field, $field->replaceHintAttributes([]));
        $this->assertNotSame($field, $field->hintId(null));
        $this->assertNotSame($field, $field->hintClass());
        $this->assertNotSame($field, $field->replaceHintClass());
        $this->assertNotSame($field, $field->hint(null));
        $this->assertNotSame($field, $field->errorConfig([]));
        $this->assertNotSame($field, $field->errorAttributes([]));
        $this->assertNotSame($field, $field->replaceErrorAttributes([]));
        $this->assertNotSame($field, $field->errorId(null));
        $this->assertNotSame($field, $field->errorClass());
        $this->assertNotSame($field, $field->replaceErrorClass());
        $this->assertNotSame($field, $field->error(null));
    }
}
