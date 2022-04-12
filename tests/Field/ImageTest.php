<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field\Image;
use Yiisoft\Form\Tests\Support\AssertTrait;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class ImageTest extends TestCase
{
    use AssertTrait;

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
        $this->assertStringContainsStringIgnoringLineEndings(
            <<<HTML
            <div>
            <input type="image" src="btn.png" alt="Go">
            </div>
            HTML,
            $result
        );
    }

    public function dataDisabled(): array
    {
        return [
            ['<input type="image">', null],
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
}
