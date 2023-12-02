<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field\Base;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Tests\Support\StringableObject;
use Yiisoft\Form\Tests\Support\StubFieldContentTrait;
use Yiisoft\Form\ThemeContainer;
use Yiisoft\Html\Tag\P;
use Yiisoft\Html\Tag\Span;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class FieldContentTraitTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer());
        ThemeContainer::initialize();
    }

    public function testBase(): void
    {
        $result = (new StubFieldContentTrait())
            ->content('<b>hello &gt; world!</b>')
            ->getContent();

        $this->assertSame('&lt;b&gt;hello &amp;gt; world!&lt;/b&gt;', $result);
    }

    public function testNamedParametersContent(): void
    {
        $result = (new StubFieldContentTrait())
            ->content(content: '1')
            ->addContent(content: '2')
            ->addContent(content: '3')
            ->getContent();

        $this->assertSame('123', $result);
    }

    public function testWithoutEncode(): void
    {
        $result = (new StubFieldContentTrait())
            ->content('<b>hello</b>')
            ->encodeContent(false)
            ->getContent();

        $this->assertSame('<b>hello</b>', $result);
    }

    public function testWithoutDoubleEncode(): void
    {
        $result = (new StubFieldContentTrait())
            ->content('<b>A &gt; B</b>')
            ->doubleEncodeContent(false)
            ->getContent();

        $this->assertSame('&lt;b&gt;A &gt; B&lt;/b&gt;', $result);
    }

    public static function dataContent(): array
    {
        return [
            'string' => ['hello', 'hello'],
            'string-tag' => ['&lt;p&gt;Hi!&lt;/p&gt;', '<p>Hi!</p>'],
            'object-tag' => ['<p>Hi!</p>', P::tag()->content('Hi!')],
            'array' => [
                'Hello &gt; <span>World</span>!',
                ['Hello', ' > ', Span::tag()->content('World'), '!'],
            ],
        ];
    }

    #[DataProvider('dataContent')]
    public function testContent(string $expected, $content): void
    {
        $object = new StubFieldContentTrait();
        $object = is_array($content)
            ? $object->content(...$content)
            : $object->content($content);

        $this->assertSame($expected, $object->getContent());
    }

    public function testEncodeContent(): void
    {
        $result = (new StubFieldContentTrait())
            ->content(P::tag()->content('Hi!'))
            ->encodeContent(true)
            ->getContent();

        $this->assertSame('&lt;p&gt;Hi!&lt;/p&gt;', $result);
    }

    public function testAddContent(): void
    {
        $result = (new StubFieldContentTrait())
            ->content('Hello')
            ->addContent(' ')
            ->addContent(new StringableObject('World'))
            ->getContent();

        $this->assertSame('Hello World', $result);
    }

    public function testAddContentVariadic(): void
    {
        $result = (new StubFieldContentTrait())
            ->content('1')
            ->addContent(...['2', '3'])
            ->getContent();

        $this->assertSame('123', $result);
    }

    public function testImmutability(): void
    {
        $object = new StubFieldContentTrait();

        $this->assertNotSame($object, $object->encodeContent(true));
        $this->assertNotSame($object, $object->doubleEncodeContent(true));
        $this->assertNotSame($object, $object->content(''));
        $this->assertNotSame($object, $object->addContent(''));
    }
}
