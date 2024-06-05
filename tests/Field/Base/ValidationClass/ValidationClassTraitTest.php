<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field\Base\ValidationClass;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\PureField\InputData;
use Yiisoft\Form\Tests\Support\ValidationClass\ValidationClassField;
use Yiisoft\Form\Theme\ThemeContainer;

final class ValidationClassTraitTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        ThemeContainer::initialize();
    }

    public static function dataBase(): array
    {
        return [
            'null' => [
                "<b>\n</b>",
                null,
            ],
            'valid' => [
                "<b>valid\ninput-valid</b>",
                [],
            ],
            'invalid' => [
                "<b>invalid\ninput-invalid</b>",
                ['error'],
            ],
        ];
    }

    #[DataProvider('dataBase')]
    public function testBase(string $expected, ?array $validationErrors): void
    {
        $field = ValidationClassField::widget()
            ->validClass('valid')
            ->invalidClass('invalid')
            ->inputValidClass('input-valid')
            ->inputInvalidClass('input-invalid');

        $result = $field
            ->useContainer(false)
            ->template('{input}')
            ->inputData(new InputData(validationErrors: $validationErrors))
            ->render();

        $this->assertSame($expected, $result);
    }

    public function testImmutability(): void
    {
        $field = ValidationClassField::widget();

        $this->assertNotSame($field, $field->invalidClass(null));
        $this->assertNotSame($field, $field->validClass(null));
        $this->assertNotSame($field, $field->inputInvalidClass(null));
        $this->assertNotSame($field, $field->inputValidClass(null));
    }
}
