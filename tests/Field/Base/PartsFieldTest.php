<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field\Base;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Tests\Support\AssertTrait;
use Yiisoft\Form\Tests\Support\StubPartsField;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class PartsFieldTest extends TestCase
{
    use AssertTrait;

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer());
    }

    public function testBase(): void
    {
        $field = StubPartsField::widget()
            ->tokens([
                '{before}' => '<section>',
                '{after}' => '</section>',
            ])
            ->token('{icon}', '<span class="icon"></span>')
            ->template("{before}\n{input}\n{icon}\n{after}");

        $expected = <<<HTML
                    <div>
                    <section>
                    <span class="icon"></span>
                    </section>
                    </div>
                    HTML;

        $this->assertSame($expected, $field->render());
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
