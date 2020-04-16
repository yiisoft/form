<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Html;

use Yiisoft\Form\Html\CheckBoxForm;
use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Tests\Stub\StubForm;

final class CheckBoxFormTest extends TestCase
{
    /**
     * Data provider for {@see Checkbox()}.
     *
     * @return array test data.
     */
    public function dataProviderActiveCheckbox(): array
    {
        return [
            [
                true,
                ['uncheck' => false],
                '<label><input type="checkbox" id="stubform-fieldcheck" name="StubForm[fieldCheck]" value="1" checked> Field Check</label>',
            ],
            [
                true,
                [],
                '<input type="hidden" name="StubForm[fieldCheck]" value="0"><label><input type="checkbox" id="stubform-fieldcheck" name="StubForm[fieldCheck]" value="1" checked> Field Check</label>',
            ],
            [
                true,
                ['label' => false],
                '<input type="hidden" name="StubForm[fieldCheck]" value="0"><input type="checkbox" id="stubform-fieldcheck" name="StubForm[fieldCheck]" value="1" checked>',
            ],
            [
                true,
                ['uncheck' => false, 'label' => false],
                '<input type="checkbox" id="stubform-fieldcheck" name="StubForm[fieldCheck]" value="1" checked>',
            ],
        ];
    }

    /**
     * @dataProvider dataProviderActiveCheckbox
     *
     * @param bool $value
     * @param array $options
     * @param string $expected
     */
    public function testCheckboxForm(bool $value, array $options, string $expected)
    {
        $form = new StubForm();
        $form->fieldBool($value);

        $this->assertEquals($expected, CheckBoxForm::create($form, 'fieldCheck', $options));
    }
}
