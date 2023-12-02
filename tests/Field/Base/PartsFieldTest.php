<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field\Base;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use stdClass;
use Yiisoft\Form\Tests\Support\StubPartsField;
use Yiisoft\Form\ThemeContainer;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class PartsFieldTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer());
        ThemeContainer::initialize();
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

    public function testAddLabelAttributes(): void
    {
        $result = StubPartsField::widget()
            ->label('test')
            ->addLabelAttributes(['class' => 'red'])
            ->addLabelAttributes(['id' => 'KEY'])
            ->render();

        $expected = <<<HTML
            <div>
            <label id="KEY" class="red">test</label>
            </div>
            HTML;

        $this->assertSame($expected, $result);
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

    public function testAddLabelClass(): void
    {
        $result = StubPartsField::widget()
            ->label('test')
            ->addLabelClass('red')
            ->addLabelClass('blue')
            ->render();

        $expected = <<<HTML
            <div>
            <label class="red blue">test</label>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testLabelClass(): void
    {
        $result = StubPartsField::widget()
            ->label('test')
            ->addLabelClass('red')
            ->labelClass('blue')
            ->render();

        $expected = <<<HTML
            <div>
            <label class="blue">test</label>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testAddHintAttributes(): void
    {
        $result = StubPartsField::widget()
            ->hint('test')
            ->addHintAttributes(['class' => 'red'])
            ->addHintAttributes(['id' => 'KEY'])
            ->render();

        $expected = <<<HTML
            <div>
            <div id="KEY" class="red">test</div>
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

    public function testAddHintClass(): void
    {
        $result = StubPartsField::widget()
            ->hint('test')
            ->addHintClass('red')
            ->addHintClass('blue')
            ->render();

        $expected = <<<HTML
            <div>
            <div class="red blue">test</div>
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
            <div class="blue">test</div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testAddErrorAttributes(): void
    {
        $result = StubPartsField::widget()
            ->error('test')
            ->addErrorAttributes(['class' => 'red'])
            ->addErrorAttributes(['id' => 'KEY'])
            ->render();

        $expected = <<<HTML
            <div>
            <div id="KEY" class="red">test</div>
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

    public function testAddErrorClass(): void
    {
        $result = StubPartsField::widget()
            ->error('test')
            ->addErrorClass('red')
            ->addErrorClass('blue')
            ->render();

        $expected = <<<HTML
            <div>
            <div class="red blue">test</div>
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
            <div class="blue">test</div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testEmptyInputContainerTag(): void
    {
        $field = StubPartsField::widget();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Tag name cannot be empty.');
        $field->inputContainerTag('');
    }

    public function testAddInputContainerAttributes(): void
    {
        $result = StubPartsField::widget()
            ->setInputHtml('<input>')
            ->inputContainerTag('p')
            ->addInputContainerAttributes(['class' => 'red'])
            ->addInputContainerAttributes(['id' => 'KEY'])
            ->render();

        $expected = <<<HTML
            <div>
            <p id="KEY" class="red"><input></p>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testInputContainerAttributes(): void
    {
        $result = StubPartsField::widget()
            ->setInputHtml('<input>')
            ->inputContainerTag('p')
            ->inputContainerAttributes(['class' => 'red'])
            ->inputContainerAttributes(['id' => 'KEY'])
            ->render();

        $expected = <<<HTML
            <div>
            <p id="KEY"><input></p>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public static function dataAddContainerClass(): array
    {
        return [
            [' class="main"', []],
            [' class="main"', ['main']],
            [' class="main bold"', ['bold']],
            [' class="main italic bold"', ['italic bold']],
            [' class="main italic bold"', ['italic', 'bold']],
        ];
    }

    /**
     * @param string[] $class
     */
    #[DataProvider('dataAddContainerClass')]
    public function testAddContainerClass(string $expectedClassAttribute, array $class): void
    {
        $result = StubPartsField::widget()
            ->setInputHtml('<input>')
            ->inputContainerTag('p')
            ->addInputContainerClass('main')
            ->addInputContainerClass(...$class)
            ->render();

        $expected = <<<HTML
            <div>
            <p$expectedClassAttribute><input></p>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public static function dataAddContainerNewClass(): array
    {
        return [
            ['', null],
            [' class', ''],
            [' class="red"', 'red'],
        ];
    }

    #[DataProvider('dataAddContainerNewClass')]
    public function testAddContainerNewClass(string $expectedClassAttribute, ?string $class): void
    {
        $result = StubPartsField::widget()
            ->setInputHtml('<input>')
            ->inputContainerTag('p')
            ->addInputContainerClass($class)
            ->render();

        $expected = <<<HTML
            <div>
            <p$expectedClassAttribute><input></p>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public static function dataContainerClass(): array
    {
        return [
            ['', []],
            ['', [null]],
            [' class', ['']],
            [' class="main"', ['main']],
            [' class="main bold"', ['main bold']],
            [' class="main bold"', ['main', 'bold']],
        ];
    }

    /**
     * @param string[] $class
     */
    #[DataProvider('dataContainerClass')]
    public function testContainerClass(string $expectedClassAttribute, array $class): void
    {
        $result = StubPartsField::widget()
            ->setInputHtml('<input>')
            ->inputContainerTag('p')
            ->inputContainerClass('red')
            ->inputContainerClass(...$class)
            ->render();

        $expected = <<<HTML
            <div>
            <p$expectedClassAttribute><input></p>
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
        $this->assertNotSame($field, $field->inputContainerTag(null));
        $this->assertNotSame($field, $field->inputContainerAttributes([]));
        $this->assertNotSame($field, $field->addInputContainerAttributes([]));
        $this->assertNotSame($field, $field->inputContainerClass());
        $this->assertNotSame($field, $field->addInputContainerClass());
        $this->assertNotSame($field, $field->labelConfig([]));
        $this->assertNotSame($field, $field->labelAttributes([]));
        $this->assertNotSame($field, $field->addLabelAttributes([]));
        $this->assertNotSame($field, $field->labelId(null));
        $this->assertNotSame($field, $field->labelClass());
        $this->assertNotSame($field, $field->addLabelClass());
        $this->assertNotSame($field, $field->label(null));
        $this->assertNotSame($field, $field->hintConfig([]));
        $this->assertNotSame($field, $field->hintAttributes([]));
        $this->assertNotSame($field, $field->addHintAttributes([]));
        $this->assertNotSame($field, $field->hintId(null));
        $this->assertNotSame($field, $field->hintClass());
        $this->assertNotSame($field, $field->addHintClass());
        $this->assertNotSame($field, $field->hint(null));
        $this->assertNotSame($field, $field->errorConfig([]));
        $this->assertNotSame($field, $field->errorAttributes([]));
        $this->assertNotSame($field, $field->addErrorAttributes([]));
        $this->assertNotSame($field, $field->errorId(null));
        $this->assertNotSame($field, $field->errorClass());
        $this->assertNotSame($field, $field->addErrorClass());
        $this->assertNotSame($field, $field->error(null));
    }
}
