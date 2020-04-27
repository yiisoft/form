<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Html;

use Yiisoft\Factory\Exceptions\InvalidConfigException;
use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Tests\Stub\StubForm;
use Yiisoft\Form\Widget\TextArea;

final class TextAreaTest extends TestCase
{
    /**
     * Data provider for {@see testTextArea()}.
     *
     * @return array test data.
     */
    public function dataProviderTextArea(): array
    {
        return [
            [
                'some text',
                ['placeholder' => true],
                '<textarea id="stubform-fieldstring" name="StubForm[fieldString]" placeholder="Field String">some text</textarea>',
            ],
            [
                'some text',
                [
                    'maxlength' => 500
                ],
                '<textarea id="stubform-fieldstring" name="StubForm[fieldString]" maxlength="500">some text</textarea>',
            ],
            [
                'some text',
                [
                    'maxlength' => 99
                ],
                '<textarea id="stubform-fieldstring" name="StubForm[fieldString]" maxlength="99">some text</textarea>',
            ],
            [
                'some text',
                [
                    'placeholder' => 'Override Text',
                    'value' => 'Override Text',
                ],
                '<textarea id="stubform-fieldstring" name="StubForm[fieldString]" placeholder="Override Text">Override Text</textarea>',
            ],
        ];
    }

    /**
     * @dataProvider dataProviderTextArea
     *
     * @param string $value
     * @param array $options
     * @param string $expected
     *
     * @throws InvalidConfigException
     */
    public function testTextArea(string $value, array $options, $expected): void
    {
        $form = new StubForm();
        $form->fieldString($value);
        $created = TextArea::widget()
            ->config($form, 'fieldString', $options)
            ->run();
        $this->assertEquals($expected, $created);
    }
}
