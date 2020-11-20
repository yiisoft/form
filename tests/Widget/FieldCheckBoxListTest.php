<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use Yiisoft\Form\Tests\Stub\PersonalForm;
use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Widget\Field;

final class FieldCheckBoxListTest extends TestCase
{
    public function testFieldCheckBoxList(): void
    {
        $data = new PersonalForm();
        $data->sex(1);

        $expected = <<<'HTML'
<div class="form-group field-personalform-sex">
<label class="control-label" for="personalform-sex">Sex</label>
<input type="hidden" name="PersonalForm[sex]" value=""><div id="personalform-sex"><label><input type="checkbox" name="PersonalForm[sex][]" value="0"> Female</label>
<label><input type="checkbox" name="PersonalForm[sex][]" value="1" checked> Male</label></div>

<div class="help-block"></div>
</div>
HTML;
        $html = Field::widget()
            ->config($data, 'sex')
            ->checkboxList(['Female', 'Male'])
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testFieldCheckBoxListWithLabelCustom(): void
    {
        $data = new PersonalForm();
        $data->sex(1);

        $expected = <<<'HTML'
<div class="form-group field-personalform-sex">
<label class="control-label customLabelClass" for="personalform-sex">Sex:</label>
<input type="hidden" name="PersonalForm[sex]" value="0"><div id="personalform-sex"><label><input type="checkbox" name="PersonalForm[sex][]" value="0"> Female</label>
<label><input type="checkbox" name="PersonalForm[sex][]" value="1" checked> Male</label></div>

<div class="help-block"></div>
</div>
HTML;
        $html = Field::widget()
            ->config($data, 'sex')
            ->label(true, ['class' => 'customLabelClass'], 'Sex:')
            ->checkboxList(
                ['Female', 'Male'],
                ['unselect' => '0']
            )
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testFieldCheckBoxWithoutAnyLabel(): void
    {
        $data = new PersonalForm();
        $data->sex(1);

        $expected = <<<'HTML'
<div class="form-group field-personalform-sex">

<input type="hidden" name="PersonalForm[sex]" value="0"><div id="personalform-sex"><label><input type="checkbox" name="PersonalForm[sex][]" value="0"> Female</label>
<label><input type="checkbox" name="PersonalForm[sex][]" value="1" checked> Male</label></div>

<div class="help-block"></div>
</div>
HTML;
        $html = Field::widget()
            ->config($data, 'sex')
            ->label(false)
            ->checkboxList(['Female', 'Male'], ['unselect' => '0'])
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }
}
