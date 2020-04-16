<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Html;

use Yiisoft\Form\Html\TextAreaForm;
use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Tests\Stub\StubForm;

final class TextAreaFormTest extends TestCase
{
    /**
     * Data provider for {@see testTextAreaForm()}.
     *
     * @return array test data.
     */
    public function dataProviderTextAreaForm(): array
    {
        return [
            [
                'some text',
                [],
                '<textarea id="stubform-fieldstring" name="StubForm[fieldString]">some text</textarea>',
            ],
            [
                'some text',
                [
                    'maxlength' => 500,
                ],
                '<textarea id="stubform-fieldstring" name="StubForm[fieldString]" maxlength="500">some text</textarea>',
            ],
            [
                'some text',
                [
                    'maxlength' => 99,
                ],
                '<textarea id="stubform-fieldstring" name="StubForm[fieldString]" maxlength="99">some text</textarea>',
            ],
            [
                'some text',
                [
                    'value' => 'override text',
                ],
                '<textarea id="stubform-fieldstring" name="StubForm[fieldString]">override text</textarea>',
            ],
        ];
    }

    /**
     * @dataProvider dataProviderTextAreaForm
     *
     * @param string $value
     * @param array $options
     * @param string $expectedHtml
     */
    public function testActiveTextArea($value, array $options, $expectedHtml)
    {
        $form = new StubForm();
        $form->fieldString($value);

        $this->assertEquals($expectedHtml, TextAreaForm::create($form, 'fieldString', $options));
    }
}
