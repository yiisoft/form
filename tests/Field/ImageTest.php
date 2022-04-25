<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field\Image;
use Yiisoft\Form\Tests\Support\StringableObject;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class ImageTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer());
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

    public function dataWidth(): array
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

    /**
     * @dataProvider dataWidth
     */
    public function testWidth(string $expected, $width): void
    {
        $result = Image::widget()
            ->width($width)
            ->render();

        $this->assertSame($expected, $result);
    }

    public function dataHeight(): array
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

    /**
     * @dataProvider dataHeight
     */
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

    public function dataAutofocus(): array
    {
        return [
            ['<input type="image">', false],
            ['<input type="image" autofocus>', true],
        ];
    }

    /**
     * @dataProvider dataAutofocus
     */
    public function testAutofocus(string $expected, ?bool $autofocus): void
    {
        $result = Image::widget()
            ->autofocus($autofocus)
            ->useContainer(false)
            ->render();

        $this->assertSame($expected, $result);
    }

    public function dataDisabled(): array
    {
        return [
            ['<input type="image">', false],
            ['<input type="image" disabled>', true],
        ];
    }

    /**
     * @dataProvider dataDisabled
     */
    public function testDisabled(string $expected, ?bool $disabled): void
    {
        $result = Image::widget()
            ->disabled($disabled)
            ->useContainer(false)
            ->render();

        $this->assertSame($expected, $result);
    }

    public function testAriaDescribedBy(): void
    {
        $result = Image::widget()
            ->ariaDescribedBy('hint')
            ->render();

        $expected = <<<HTML
            <div>
            <input type="image" aria-describedby="hint">
            </div>
            HTML;

        $this->assertSame($expected, $result);
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

    public function testInputTagAttributes(): void
    {
        $result = Image::widget()
            ->inputTagAttributes(['class' => 'primary'])
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
        $this->assertNotSame($field, $field->inputTagAttributes([]));
    }
}
