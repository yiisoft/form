<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Tests\Stub\PersonalForm;
use Yiisoft\Form\Widget\RadioList;

final class RadioListTest extends TestCase
{
    public function testActiveRadioList(): void
    {
        $cities = [
            '1' => 'Moscu',
            '2' => 'San Petersburgo',
            '3' => 'Novosibirsk',
            '4' => 'Ekaterinburgo'
        ];

        $form = new PersonalForm();

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[cityBirth]" value="0"><div id="personalform-citybirth" class="testMe"><label><input type="radio" name="PersonalForm[cityBirth]" value="1"> Moscu</label>
<label><input type="radio" name="PersonalForm[cityBirth]" value="2" checked> San Petersburgo</label>
<label><input type="radio" name="PersonalForm[cityBirth]" value="3"> Novosibirsk</label>
<label><input type="radio" name="PersonalForm[cityBirth]" value="4"> Ekaterinburgo</label></div>
HTML;
        $form->cityBirth(2);
        $created = RadioList::widget()
            ->config($form, 'cityBirth', ['class' => 'testMe'])
            ->items($cities)
            ->unselect('0')
            ->run();
        $this->assertEqualsWithoutLE($expected, $created);
    }
}
