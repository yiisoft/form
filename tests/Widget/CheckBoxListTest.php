<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Tests\Stub\PersonalForm;
use Yiisoft\Form\Widget\CheckBoxList;

final class CheckBoxListTest extends TestCase
{
    public function testCheckboxList(): void
    {
        $form = new PersonalForm();

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[sex]" value="0"><div id="personalform-sex"><label><input type="checkbox" name="PersonalForm[sex][]" value="0"> Female</label>
<label><input type="checkbox" name="PersonalForm[sex][]" value="1"> Male</label></div>
HTML;
        $created = CheckboxList::widget()
            ->config($form, 'sex')
            ->items(['Female', 'Male'])
            ->addUnselect('0')
            ->run();
        $this->assertEqualsWithoutLE($expected, $created);
    }

    public function testCheckboxListOptions(): void
    {
        $form = new PersonalForm();

        $form->sex(0);
        $expected = <<<'HTML'
<input type="hidden" name="sex" value="0"><div id="personalform-sex"><label><input type="checkbox" name="sex[]" value="0" checked> Female</label>
<label><input type="checkbox" name="sex[]" value="1"> Male</label></div>
HTML;
        $created = CheckboxList::widget()
            ->config($form, 'sex', ['name' => 'sex'])
            ->items(['Female', 'Male'])
            ->addUnselect('0')
            ->run();
        $this->assertEqualsWithoutLE($expected, $created);

        $form->sex(1);
        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[sex]" value="1"><div id="personalform-sex" autofocus><label><input type="checkbox" class="testMe" name="PersonalForm[sex][]" value="0"> Female</label>
<label><input type="checkbox" class="testMe" name="PersonalForm[sex][]" value="1" checked> Male</label></div>
HTML;
        $created = CheckboxList::widget()
            ->config($form, 'sex')
            ->autofocus(true)
            ->items(['Female', 'Male'])
            ->addItemOptions(['class' => 'testMe'])
            ->addUnselect('1')
            ->run();
        $this->assertEqualsWithoutLE($expected, $created);
    }
}
