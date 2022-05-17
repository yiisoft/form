<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field\Base;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Tests\Support\StubBaseField;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class BaseFieldTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer());
    }

    public function dataContainerId(): array
    {
        return [
            ['', null],
            [' id="main"', 'main'],
        ];
    }

    /**
     * @dataProvider dataContainerId
     */
    public function testContainerId(string $expectedId, ?string $id): void
    {
        $result = StubBaseField::widget()
            ->containerId($id)
            ->render();

        $expected = <<<HTML
            <div$expectedId>
            test
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function dataContainerClass(): array
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
     * @dataProvider dataContainerClass
     *
     * @param string[] $class
     */
    public function testContainerClass(string $expectedClassAttribute, array $class): void
    {
        $result = StubBaseField::widget()
            ->containerClass('main')
            ->containerClass(...$class)
            ->render();

        $expected = <<<HTML
            <div$expectedClassAttribute>
            test
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function dataContainerNewClass(): array
    {
        return [
            ['', null],
            [' class', ''],
            [' class="red"', 'red'],
        ];
    }

    /**
     * @dataProvider dataContainerNewClass
     */
    public function testContainerNewClass(string $expectedClassAttribute, ?string $class): void
    {
        $result = StubBaseField::widget()
            ->containerClass($class)
            ->render();

        $expected = <<<HTML
            <div$expectedClassAttribute>
            test
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function dataReplaceContainerClass(): array
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
     * @dataProvider dataReplaceContainerClass
     *
     * @param string[] $class
     */
    public function testReplaceContainerClass(string $expectedClassAttribute, array $class): void
    {
        $result = StubBaseField::widget()
            ->containerClass('red')
            ->replaceContainerClass(...$class)
            ->render();

        $expected = <<<HTML
            <div$expectedClassAttribute>
            test
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testBeginEnd(): void
    {
        $field = StubBaseField::widget();

        $result = $field->begin() . 'content' . StubBaseField::end();

        $this->assertSame('<div>content</div>', $result);
    }

    public function testBeginEndWithoutContainer(): void
    {
        $field = StubBaseField::widget()->useContainer(false);

        $result = $field->begin() . 'content' . StubBaseField::end();

        $this->assertSame('content', $result);
    }

    public function testImmutability(): void
    {
        $field = StubBaseField::widget();

        $this->assertNotSame($field, $field->containerTag('div'));
        $this->assertNotSame($field, $field->containerAttributes([]));
        $this->assertNotSame($field, $field->containerId(null));
        $this->assertNotSame($field, $field->containerClass());
        $this->assertNotSame($field, $field->replaceContainerClass());
        $this->assertNotSame($field, $field->useContainer(true));
    }
}
