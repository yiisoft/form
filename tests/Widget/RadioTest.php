<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Tests\Stub\StubForm;
use Yiisoft\Form\Widget\Radio;

final class RadioTest extends TestCase
{
    public function dataProviderRadio(): array
    {
        return [
            [
                true,
                true,
                true,
                [],
                '<input type="hidden" name="StubForm[fieldBool]" value="0"><label><input type="radio" id="stubform-fieldbool" name="StubForm[fieldBool]" value="1" checked> Field Bool</label>',
            ]
        ];
    }

    /**
     * @dataProvider dataProviderRadio
     *
     * @param bool $value
     * @param bool $label
     * @param bool $uncheck
     * @param array $options
     * @param string $expected
     */
    public function testRadio(bool $value, bool $label, bool $uncheck, array $options, string $expected): void
    {
        $form = new StubForm();
        $form->fieldBool($value);
        $created = Radio::widget()
            ->form($form)
            ->attribute('fieldBool')
            ->options($options)
            ->label($label)
            ->uncheck($uncheck)
            ->run();
        $this->assertEquals($expected, $created);
    }
}
