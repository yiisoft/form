<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field\Base;

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

    public function dataAddContainerClass(): array
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
     * @dataProvider dataAddContainerClass
     *
     * @param string[] $class
     */
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

    public function dataAddContainerNewClass(): array
    {
        return [
            ['', null],
            [' class', ''],
            [' class="red"', 'red'],
        ];
    }

    /**
     * @dataProvider dataAddContainerNewClass
     */
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

    public function dataContainerClass(): array
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
     * @dataProvider dataContainerClass
     *
     * @param string[] $class
     */
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

        $result = $field->begin() . 'content' . StubBaseField::end();

        $this->assertSame('<div>content</div>', $result);
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
