<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field\Image;
use Yiisoft\Form\Tests\Support\StringableObject;
use Yiisoft\Form\Theme\ThemeContainer;

final class ImageTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        ThemeContainer::initialize();
    }

    public function testBase(): void
    {
        $result = Image::widget()
            ->src('btn.png')
            ->alt('Go')
            ->render();
        $this->assertSame(
            <<<HTML
            <div>
            <input type="image" src="btn.png" alt="Go">
            </div>
            HTML,
            $result
        );
    }

    public function testAlt(): void
    {
        $result = Image::widget()
            ->alt('test')
            ->render();

        $expected = <<<HTML
            <div>
            <input type="image" alt="test">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public static function dataWidth(): array
    {
        return [
            'int' => [
                <<<HTML
                <div>
                <input type="image" width="42">
                </div>
                HTML,
                42,
            ],
            'string' => [
                <<<HTML
                <div>
                <input type="image" width="53">
                </div>
                HTML,
                '53',
            ],
            'Stringable' => [
                <<<HTML
                <div>
                <input type="image" width="7">
                </div>
                HTML,
                new StringableObject('7'),
            ],
            'null' => [
                <<<HTML
                <div>
                <input type="image">
                </div>
                HTML,
                null,
            ],
        ];
    }

    #[DataProvider('dataWidth')]
    public function testWidth(string $expected, $width): void
    {
        $result = Image::widget()
            ->width($width)
            ->render();

        $this->assertSame($expected, $result);
    }

    public static function dataHeight(): array
    {
        return [
            'int' => [
                <<<HTML
                <div>
                <input type="image" height="42">
                </div>
                HTML,
                42,
            ],
            'string' => [
                <<<HTML
                <div>
                <input type="image" height="53">
                </div>
                HTML,
                '53',
            ],
            'Stringable' => [
                <<<HTML
                <div>
                <input type="image" height="7">
                </div>
                HTML,
                new StringableObject('7'),
            ],
            'null' => [
                <<<HTML
                <div>
                <input type="image">
                </div>
                HTML,
                null,
            ],
        ];
    }

    #[DataProvider('dataHeight')]
    public function testHeight(string $expected, $height): void
    {
        $result = Image::widget()
            ->height($height)
            ->render();

        $this->assertSame($expected, $result);
    }

    public function testSrc(): void
    {
        $result = Image::widget()
            ->src('button.png')
            ->render();

        $expected = <<<HTML
            <div>
            <input type="image" src="button.png">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public static function dataAutofocus(): array
    {
        return [
            ['<input type="image">', false],
            ['<input type="image" autofocus>', true],
            ['<input type="image" autofocus>', null],
        ];
    }

    #[DataProvider('dataAutofocus')]
    public function testAutofocus(string $expected, ?bool $autofocus): void
    {
        $widget = Image::widget()->useContainer(false);
        $widget = $autofocus === null ? $widget->autofocus() : $widget->autofocus($autofocus);

        $result = $widget->render();

        $this->assertSame($expected, $result);
    }

    public static function dataDisabled(): array
    {
        return [
            ['<input type="image">', false],
            ['<input type="image" disabled>', true],
            ['<input type="image" disabled>', null],
        ];
    }

    #[DataProvider('dataDisabled')]
    public function testDisabled(string $expected, ?bool $disabled): void
    {
        $widget = Image::widget()->useContainer(false);
        $widget = $disabled === null ? $widget->disabled() : $widget->disabled($disabled);

        $result = $widget->render();

        $this->assertSame($expected, $result);
    }

    public static function dataAriaDescribedBy(): array
    {
        return [
            'one element' => [
                ['hint'],
                <<<HTML
                <div>
                <input type="image" aria-describedby="hint">
                </div>
                HTML,
            ],
            'multiple elements' => [
                ['hint1', 'hint2'],
                <<<HTML
                <div>
                <input type="image" aria-describedby="hint1 hint2">
                </div>
                HTML,
            ],
            'null with other elements' => [
                ['hint1', null, 'hint2', null, 'hint3'],
                <<<HTML
                <div>
                <input type="image" aria-describedby="hint1 hint2 hint3">
                </div>
                HTML,
            ],
            'only null' => [
                [null, null],
                <<<HTML
                <div>
                <input type="image">
                </div>
                HTML,
            ],
            'empty string' => [
                [''],
                <<<HTML
                <div>
                <input type="image" aria-describedby>
                </div>
                HTML,
            ],
        ];
    }

    #[DataProvider('dataAriaDescribedBy')]
    public function testAriaDescribedBy(array $ariaDescribedBy, string $expectedHtml): void
    {
        $actualHtml = Image::widget()
            ->ariaDescribedBy(...$ariaDescribedBy)
            ->render();
        $this->assertSame($expectedHtml, $actualHtml);
    }

    public function testAriaLabel(): void
    {
        $result = Image::widget()
            ->ariaLabel('test')
            ->render();

        $expected = <<<HTML
            <div>
            <input type="image" aria-label="test">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testTabIndex(): void
    {
        $result = Image::widget()
            ->tabIndex(5)
            ->render();

        $expected = <<<HTML
            <div>
            <input type="image" tabindex="5">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testAddInputAttributes(): void
    {
        $result = Image::widget()
            ->addInputAttributes(['id' => 'TEST'])
            ->addInputAttributes(['class' => 'primary'])
            ->render();

        $expected = <<<HTML
            <div>
            <input type="image" id="TEST" class="primary">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testInputAttributes(): void
    {
        $result = Image::widget()
            ->inputAttributes(['id' => 'TEST'])
            ->inputAttributes(['class' => 'primary'])
            ->render();

        $expected = <<<HTML
            <div>
            <input type="image" class="primary">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testImmutability(): void
    {
        $field = Image::widget();

        $this->assertNotSame($field, $field->alt(null));
        $this->assertNotSame($field, $field->width(null));
        $this->assertNotSame($field, $field->height(null));
        $this->assertNotSame($field, $field->src(null));
        $this->assertNotSame($field, $field->autofocus());
        $this->assertNotSame($field, $field->disabled());
        $this->assertNotSame($field, $field->ariaDescribedBy(null));
        $this->assertNotSame($field, $field->ariaLabel(null));
        $this->assertNotSame($field, $field->tabIndex(null));
        $this->assertNotSame($field, $field->inputAttributes([]));
        $this->assertNotSame($field, $field->addInputAttributes([]));
    }
}
