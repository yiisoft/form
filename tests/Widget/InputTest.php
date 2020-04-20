<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Html;

use Yiisoft\Factory\Exceptions\InvalidConfigException;
use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Tests\Stub\StubForm;
use Yiisoft\Form\Widget\Input;

final class InputTest extends TestCase
{
    /**
     * Data provider for {@see testInputForm}.
     *
     * @return array test data.
     */
    public function dataProviderInput(): array
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
     * @dataProvider dataProviderInput
     *
     * @param string $value
     * @param array $options
     * @param string $expected
     *
     * @throws InvalidConfigException
     */
    public function testInput(string $value, array $options, string $expected): void
    {
        $form = new StubForm();
        $form->fieldString($value);
        $created = Input::widget()
            ->type('text')
            ->data($form)
            ->attribute('fieldString')
            ->options($options)
            ->run();
        $this->assertEquals($expected, $created);
    }
}
