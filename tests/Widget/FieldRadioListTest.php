<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use Yiisoft\Form\Tests\Stub\PersonalForm;
use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Widget\Field;

final class FieldRadioListTest extends TestCase
{
    public function testFieldRadioList(): void
    {
        $data = new PersonalForm();
        $data->terms(true);

        $expected = <<<'HTML'
<div class="form-group field-personalform-sex">
<label class="control-label" for="personalform-sex">Sex</label>
<input type="hidden" name="PersonalForm[sex]" value=""><div id="personalform-sex" class="form-control" role="radiogroup"><label><input type="radio" name="PersonalForm[sex]" value="1"> Female</label>
<label><input type="radio" name="PersonalForm[sex]" value="2"> Male</label></div>

<div class="help-block"></div>
</div>
HTML;
        $html = Field::widget()
            ->config($data, 'sex')
            ->radioList(['1' => 'Female', '2' => 'Male'], ['unselect' => ''])
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testFieldRadioListWithLabelCustom(): void
    {
        $data = new PersonalForm();
        $data->terms(true);

        $expected = <<<'HTML'
<div class="form-group field-personalform-sex">
<label class="control-label customClass" for="personalform-sex">Sex:</label>
<input type="hidden" name="PersonalForm[sex]" value=""><div id="personalform-sex" class="form-control" role="radiogroup"><label><input type="radio" name="PersonalForm[sex]" value="1"> Female</label>
<label><input type="radio" name="PersonalForm[sex]" value="2"> Male</label></div>

<div class="help-block"></div>
</div>
HTML;
        $html = Field::widget()
            ->config($data, 'sex')
            ->label(true, ['class' => 'customClass'], 'Sex:')
            ->radioList(['1' => 'Female', '2' => 'Male'], ['unselect' => ''])
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testFieldRadioListAnyLabel(): void
    {
        $data = new PersonalForm();
        $data->terms(true);

        $expected = <<<'HTML'
<div class="form-group field-personalform-sex">

<input type="hidden" name="PersonalForm[sex]" value=""><div id="personalform-sex" class="form-control" role="radiogroup"><label><input type="radio" name="PersonalForm[sex]" value="1"> Female</label>
<label><input type="radio" name="PersonalForm[sex]" value="2"> Male</label></div>

<div class="help-block"></div>
</div>
HTML;
        $html = Field::widget()
            ->config($data, 'sex')
            ->label(false)
            ->radioList(['1' => 'Female', '2' => 'Male'], ['unselect' => ''])
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }
}
