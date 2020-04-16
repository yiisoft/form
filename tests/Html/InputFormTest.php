<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Html;

use Yiisoft\Form\Html\InputForm;
use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Tests\Stub\StubForm;

final class InputFormTest extends TestCase
{
    /**
     * Data provider for {@see testInputForm}.
     *
     * @return array test data.
     */
    public function dataProviderInputForm(): array
    {
        return [
            [
                '',
                [
                    'class' => 'testMe',
                ],
                '<input type="text" id="stubform-fieldstring" class="testMe" name="StubForm[fieldString]" value="">',
            ],
            [
                'some text',
                [],
                '<input type="text" id="stubform-fieldstring" name="StubForm[fieldString]" value="some text">',
            ],
            [
                '',
                [
                    'maxlength' => 40,
                ],
                '<input type="text" id="stubform-fieldstring" name="StubForm[fieldString]" value="" maxlength="40">',
            ],
        ];
    }

    /**
     * @dataProvider dataProviderInputForm
     *
     * @param string $value
     * @param array $options
     * @param string $expected
     */
    public function testInputForm(string $value, array $options, string $expected): void
    {
        $form = new StubForm();
        $form->fieldString($value);

        $this->assertEquals($expected, InputForm::create('text', $form, 'fieldString', $options));
    }
}
