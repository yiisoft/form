<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Tests\Stub\PersonalForm;
use Yiisoft\Form\Widget\CheckBox;

final class CheckBoxTest extends TestCase
{
    /**
     * Data provider for {@see Checkbox()}.
     *
     * @return array test data.
     */
    public function dataProviderCheckbox(): array
    {
        return [
            [
                true,
                true,
                true,
                [],
                '<input type="hidden" name="PersonalForm[terms]" value="0"><label><input type="checkbox" id="personalform-terms" name="PersonalForm[terms]" value="1" checked> Terms</label>',
            ],
            [
                true,
                true,
                false,
                [],
                '<label><input type="checkbox" id="personalform-terms" name="PersonalForm[terms]" value="1" checked> Terms</label>',
            ],
            [
                true,
                false,
                true,
                [],
                '<input type="hidden" name="PersonalForm[terms]" value="0"><input type="checkbox" id="personalform-terms" name="PersonalForm[terms]" value="1" checked>',
            ],
            [
                true,
                false,
                false,
                [],
                '<input type="checkbox" id="personalform-terms" name="PersonalForm[terms]" value="1" checked>',
            ],
        ];
    }

    /**
     * @dataProvider dataProviderCheckbox
     *
     * @param bool $value
     * @param bool $label
     * @param bool $uncheck
     * @param array $options
     * @param string $expected
     */
    public function testCheckbox(bool $value, bool $label, bool $uncheck, array $options, string $expected): void
    {
        $form = new PersonalForm();
        $form->terms($value);

        $created = CheckBox::widget()
            ->config($form, 'terms', $options)
            ->addLabel($label)
            ->addUncheck($uncheck)
            ->run();
        $this->assertEquals($expected, $created);
    }
}
