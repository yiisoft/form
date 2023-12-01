<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\YiisoftFormModel;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Tests\YiisoftFormModel\Support\Form\FormWithNestedStructures;
use Yiisoft\Form\YiisoftFormModel\FormModel;
use Yiisoft\Form\YiisoftFormModel\FormModelInputData;

final class FormModelInputDataTest extends TestCase
{
    public function dataNameAndId(): array
    {
        return [
            [
                'FormWithNestedStructures[coordinates][latitude]',
                'formwithnestedstructures-coordinates-latitude',
                new FormWithNestedStructures(),
                'coordinates[latitude]',
            ],
            [
                'FormWithNestedStructures[array][nested][value]',
                'formwithnestedstructures-array-nested-value',
                new FormWithNestedStructures(),
                'array[nested][value]',
            ],
        ];
    }

    /**
     * @dataProvider dataNameAndId
     */
    public function testNameAndId(?string $expectedName, ?string $expectedId, FormModel $form, string $name): void
    {
        $inputData = new FormModelInputData($form, $name);

        $this->assertSame($expectedName, $inputData->getName());
        $this->assertSame($expectedId, $inputData->getId());
    }
}
