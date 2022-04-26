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

    public function testImmutability(): void
    {
        $field = StubPartsField::widget();

        $this->assertNotSame($field, $field->tokens([]));
        $this->assertNotSame($field, $field->token('{before}', ''));
        $this->assertNotSame($field, $field->template(''));
        $this->assertNotSame($field, $field->hideLabel());
        $this->assertNotSame($field, $field->labelConfig([]));
        $this->assertNotSame($field, $field->label(null));
        $this->assertNotSame($field, $field->hintConfig([]));
        $this->assertNotSame($field, $field->hint(null));
        $this->assertNotSame($field, $field->errorConfig([]));
        $this->assertNotSame($field, $field->error(null));
    }
}
