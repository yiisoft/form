<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field\Base\Placeholder;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Tests\Support\Placeholder\PlaceholderField;
use Yiisoft\Form\ThemeContainer;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class PlaceholderTraitTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer());
        ThemeContainer::initialize();
    }

    public static function dataBase(): array
    {
        return [
            'null-true' => [
                '<b></b>',
                null,
                true,
            ],
            'null-false' => [
                '<b></b>',
                null,
                true,
            ],
            'string-true' => [
                '<b>string</b>',
                'string',
                true,
            ],
            'string-false' => [
                '<b></b>',
                'string',
                false,
            ],
        ];
    }

    #[DataProvider('dataBase')]
    public function testBase(string $expected, ?string $placeholder, bool $use): void
    {
        $field = PlaceholderField::widget()
            ->placeholder($placeholder)
            ->usePlaceholder($use);

        $result = $field
            ->useContainer(false)
            ->template('{input}')
            ->render();

        $this->assertSame($expected, $result);
    }

    public function testImmutability(): void
    {
        $field = PlaceholderField::widget();

        $this->assertNotSame($field, $field->placeholder(null));
        $this->assertNotSame($field, $field->usePlaceholder(true));
    }
}
