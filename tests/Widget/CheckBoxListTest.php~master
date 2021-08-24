<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use Yiisoft\Form\Tests\Stub\PersonalForm;
use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Widget\CheckBoxList;
use Yiisoft\Html\Widget\CheckboxList\CheckboxItem;

final class CheckBoxListTest extends TestCase
{
    public function testCheckBoxList(): void
    {
        $data = new PersonalForm();
        $data->sex(1);

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[sex]" value>
<div id="personalform-sex">
<label><input type="checkbox" name="PersonalForm[sex][]" value="0"> Female</label>
<label><input type="checkbox" name="PersonalForm[sex][]" value="1" checked> Male</label>
</div>
HTML;
        $html = CheckboxList::widget()
            ->config($data, 'sex')
            ->items(['Female', 'Male'])
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testCheckBoxListOptions(): void
    {
        $data = new PersonalForm();
        $data->sex(0);

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[sex]" value>
<div id="personalform-sex" class="customClass">
<label><input type="checkbox" name="PersonalForm[sex][]" value="0" checked> Female</label>
<label><input type="checkbox" name="PersonalForm[sex][]" value="1"> Male</label>
</div>
HTML;
        $html = CheckboxList::widget()
            ->config($data, 'sex', ['class' => 'customClass'])
            ->items(['Female', 'Male'])
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testCheckBoxListUnselect(): void
    {
        $data = new PersonalForm();
        $data->sex(0);

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[sex]" value="0">
<div id="personalform-sex">
<label><input type="checkbox" name="PersonalForm[sex][]" value="0" checked> Female</label>
<label><input type="checkbox" name="PersonalForm[sex][]" value="1"> Male</label>
</div>
HTML;
        $html = CheckboxList::widget()
            ->config($data, 'sex')
            ->items(['Female', 'Male'])
            ->unselect('0')
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testCheckBoxListNoUnselect(): void
    {
        $data = new PersonalForm();
        $data->sex(0);

        $expected = <<<'HTML'
<div id="personalform-sex">
<label><input type="checkbox" name="PersonalForm[sex][]" value="0" checked> Female</label>
<label><input type="checkbox" name="PersonalForm[sex][]" value="1"> Male</label>
</div>
HTML;
        $html = CheckboxList::widget()
            ->config($data, 'sex')
            ->items(['Female', 'Male'])
            ->nounselect()
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testCheckBoxListItem(): void
    {
        $data = new PersonalForm();
        $data->sex(0);

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[sex]" value>
<div id="personalform-sex">
<div class='col-sm-12'><label><input tabindex='0' class='book' type='checkbox' checked name='PersonalForm[sex][]' value='0'> Female</label></div>
<div class='col-sm-12'><label><input tabindex='1' class='book' type='checkbox'  name='PersonalForm[sex][]' value='1'> Male</label></div>
</div>
HTML;
        $html = CheckboxList::widget()
            ->config($data, 'sex')
            ->items(['Female', 'Male'])
            ->item(static function (CheckboxItem $item) {
                $check = $item->checked ? 'checked' : '';
                return "<div class='col-sm-12'><label><input tabindex='{$item->index}' class='book' type='checkbox' {$check} name='{$item->name}' value='{$item->value}'> {$item->label}</label></div>";
            })
            ->itemOptions(['class' => 'itemClass'])
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testCheckBoxListItemsOptions(): void
    {
        $data = new PersonalForm();
        $data->sex(0);

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[sex]" value>
<div id="personalform-sex">
<label><input type="checkbox" class="itemClass" name="PersonalForm[sex][]" value="0" checked> Female</label>
<label><input type="checkbox" class="itemClass" name="PersonalForm[sex][]" value="1"> Male</label>
</div>
HTML;
        $html = CheckboxList::widget()
            ->config($data, 'sex')
            ->items(['Female', 'Male'])
            ->itemOptions(['class' => 'itemClass'])
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testCheckBoxListDisabled(): void
    {
        $data = new PersonalForm();
        $data->sex(0);

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[sex]" value disabled>
<div id="personalform-sex">
<label><input type="checkbox" name="PersonalForm[sex][]" value="0" checked disabled> Female</label>
<label><input type="checkbox" name="PersonalForm[sex][]" value="1" disabled> Male</label>
</div>
HTML;
        $html = CheckboxList::widget()
            ->config($data, 'sex')
            ->items(['Female', 'Male'])
            ->disabled()
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testCheckBoxListNoEncode(): void
    {
        $data = new PersonalForm();
        $data->sex(0);

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[sex]" value>
<div id="personalform-sex">
<label><input type="checkbox" name="PersonalForm[sex][]" value="0" checked> &#9792;</label>
<label><input type="checkbox" name="PersonalForm[sex][]" value="1"> &#9896;</label>
</div>
HTML;
        $html = CheckboxList::widget()
            ->config($data, 'sex')
            ->items(['&#9792;', '&#9896;'])
            ->noEncode()
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testCheckBoxListSeparator(): void
    {
        $data = new PersonalForm();
        $data->sex(1);

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[sex]" value>
<div id="personalform-sex">
<label><input type="checkbox" name="PersonalForm[sex][]" value="0"> Female</label>&#9866;<label><input type="checkbox" name="PersonalForm[sex][]" value="1" checked> Male</label>
</div>
HTML;
        $html = CheckboxList::widget()
            ->config($data, 'sex')
            ->items(['Female', 'Male'])
            ->separator('&#9866;')
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testCheckBoxListTag(): void
    {
        $data = new PersonalForm();
        $data->sex(0);

        /** Without container */
        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[sex]" value>
<label><input type="checkbox" name="PersonalForm[sex][]" value="0" checked> Female</label>
<label><input type="checkbox" name="PersonalForm[sex][]" value="1"> Male</label>
HTML;
        $html = CheckboxList::widget()
            ->config($data, 'sex')
            ->items(['Female', 'Male'])
            ->tag()
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);

        /** Custom container tag */
        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[sex]" value>
<span id="personalform-sex">
<label><input type="checkbox" name="PersonalForm[sex][]" value="0" checked> Female</label>
<label><input type="checkbox" name="PersonalForm[sex][]" value="1"> Male</label>
</span>
HTML;
        $html = CheckboxList::widget()
            ->config($data, 'sex')
            ->items(['Female', 'Male'])
            ->tag('span')
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }
}
