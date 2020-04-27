<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Tests\Stub\PersonalForm;
use Yiisoft\Form\Widget\DropDownList;

final class DropDownListTest extends TestCase
{
    public function testDropDownList(): void
    {
        $citys = [
            '1' => 'Moscu',
            '2' => 'San Petersburgo',
            '3' => 'Novosibirsk',
            '4' => 'Ekaterinburgo'
        ];

        $form = new PersonalForm();

        $expected = <<<'HTML'
<select id="personalform-citybirth" name="PersonalForm[cityBirth]" required>
<option value="1">Moscu</option>
<option value="2" selected>San Petersburgo</option>
<option value="3">Novosibirsk</option>
<option value="4">Ekaterinburgo</option>
</select>
HTML;
        $form->cityBirth(2);
        $created = DropDownList::widget()
            ->config($form, 'cityBirth')
            ->items($citys)
            ->addMultiple(false)
            ->addRequired(true)
            ->run();
        $this->assertEqualsWithoutLE($expected, $created);

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[cityBirth]" value="0"><select id="personalform-citybirth" name="PersonalForm[cityBirth][]" multiple size="4" required>
<option value="1">Moscu</option>
<option value="2">San Petersburgo</option>
<option value="3" selected>Novosibirsk</option>
<option value="4">Ekaterinburgo</option>
</select>
HTML;
        $form->cityBirth(3);
        $created = DropDownList::widget()
            ->config($form, 'cityBirth')
            ->items($citys)
            ->addMultiple(true)
            ->addUnselect('0')
            ->addRequired(true)
            ->run();
        $this->assertEqualsWithoutLE($expected, $created);
    }
}
