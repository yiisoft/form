<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field\Base;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Tests\Support\StubBaseField;
use Yiisoft\Form\ThemeContainer;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class BaseFieldTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer());
        ThemeContainer::initialize();
    }

    public static function dataContainerId(): array
    {
        return [
            ['', null],
            [' id="main"', 'main'],
        ];
    }

    #[DataProvider('dataContainerId')]
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

    #[DataProvider('dataAddContainerClass')]
    public function testAddContainerClass(string $expectedClassAttribute, array $class): void
    {
        $result = StubBaseField::widget()
            ->addContainerClass('main')
            ->addContainerClass(...$class)
            ->render();

        $expected = <<<HTML
            <div$expectedClassAttribute>
            test
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
        $result = StubBaseField::widget()
            ->addContainerClass($class)
            ->render();

        $expected = <<<HTML
            <div$expectedClassAttribute>
            test
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
        $result = StubBaseField::widget()
            ->containerClass('red')
            ->containerClass(...$class)
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

        $result1 = $field->begin() . 'content' . $field->render();
        $result2 = $field->render();

        $this->assertSame('<div>content</div>', $result1);
        $this->assertSame("<div>\ntest\n</div>", $result2);
    }

    public function testBeginEndWithoutContainer(): void
    {
        $field = StubBaseField::widget()->useContainer(false);

        $result = $field->begin() . 'content' . StubBaseField::end();

        $this->assertSame('content', $result);
    }

    public function testCustomTheme(): void
    {
        WidgetFactory::initialize(new SimpleContainer());
        ThemeContainer::initialize(
            configs: [
                'default' => [
                    'useContainer' => false,
                ],
                'custom-theme' => [
                    'containerClass' => 'main',
                ],
            ],
            defaultConfig: 'default',
        );

        $result = StubBaseField::widget(theme: 'custom-theme')->render();

        $this->assertSame(
            <<<HTML
            <div class="main">
            test
            </div>
            HTML,
            $result
        );
    }

    public function testNullContent(): void
    {
        $result = StubBaseField::widget(['content' => null])->render();
        $this->assertSame('', $result);
    }

    public function testEmptyContent(): void
    {
        $result = StubBaseField::widget(['content' => ''])->render();

        $expected = <<<HTML
            <div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testAddContainerAttributes(): void
    {
        $result = StubBaseField::widget()
            ->addContainerAttributes(['id' => 'key'])
            ->addContainerAttributes(['class' => 'green'])
            ->render();

        $expected = <<<HTML
            <div id="key" class="green">
            test
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testImmutability(): void
    {
        $field = StubBaseField::widget();

        $this->assertNotSame($field, $field->containerTag('div'));
        $this->assertNotSame($field, $field->containerAttributes([]));
        $this->assertNotSame($field, $field->addContainerAttributes([]));
        $this->assertNotSame($field, $field->containerId(null));
        $this->assertNotSame($field, $field->addContainerClass());
        $this->assertNotSame($field, $field->containerClass());
        $this->assertNotSame($field, $field->useContainer(true));
    }
}
