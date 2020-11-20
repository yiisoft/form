<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use Yiisoft\Form\Tests\Stub\PersonalForm;
use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Widget\Field;

final class FieldListBoxTest extends TestCase
{
    private PersonalForm $data;
    private array $cities = [];

    protected function setUp(): void
    {
        parent::setUp();

        $this->data = new PersonalForm();
        $this->cities = [
            '1' => 'Moscu',
            '2' => 'San Petersburgo',
            '3' => 'Novosibirsk',
            '4' => 'Ekaterinburgo',
        ];
    }

    public function testFieldListBox(): void
    {
        $this->data->cityBirth(3);

        $expected = <<<'HTML'
<div class="form-group field-personalform-citybirth">
<label class="control-label" for="personalform-citybirth">City Birth</label>
<input type="hidden" name="PersonalForm[cityBirth]" value=""><select id="personalform-citybirth" name="PersonalForm[cityBirth]" size="4">
<option value="1">Moscu</option>
<option value="2">San Petersburgo</option>
<option value="3" selected>Novosibirsk</option>
<option value="4">Ekaterinburgo</option>
</select>

<div class="help-block"></div>
</div>
HTML;
        $html = Field::widget()
            ->config($this->data, 'cityBirth')
            ->listBox($this->cities)
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testFieldsListBoxWithLabelCustom(): void
    {
        $this->data->cityBirth(2);

        $expected = <<<'HTML'
<div class="form-group field-personalform-citybirth">
<label class="control-label customCssLabel" for="personalform-citybirth">customLabel:</label>
<input type="hidden" name="PersonalForm[cityBirth]" value=""><select id="personalform-citybirth" name="PersonalForm[cityBirth]" size="4">
<option value="1">Moscu</option>
<option value="2" selected>San Petersburgo</option>
<option value="3">Novosibirsk</option>
<option value="4">Ekaterinburgo</option>
</select>

<div class="help-block"></div>
</div>
HTML;
        $html = Field::widget()
            ->config($this->data, 'cityBirth')
            ->label(true, ['class' => 'customCssLabel'], 'customLabel:')
            ->listBox($this->cities)
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testFieldsListBoxAnyLabel(): void
    {
        $this->data->cityBirth(2);

        $expected = <<<'HTML'
<div class="form-group field-personalform-citybirth">

<input type="hidden" name="PersonalForm[cityBirth]" value=""><select id="personalform-citybirth" name="PersonalForm[cityBirth]" size="4">
<option value="1">Moscu</option>
<option value="2" selected>San Petersburgo</option>
<option value="3">Novosibirsk</option>
<option value="4">Ekaterinburgo</option>
</select>

<div class="help-block"></div>
</div>
HTML;
        $html = Field::widget()
            ->config($this->data, 'cityBirth')
            ->label(false)
            ->listBox($this->cities)
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testFieldListBoxIssue8848(): void
    {
        /** https://github.com/yiisoft/yii2/issues/8848 */
        $expected = <<<'HTML'
<div class="form-group field-personalform-citybirth">
<label class="control-label" for="personalform-citybirth">City Birth</label>
<input type="hidden" name="PersonalForm[cityBirth]" value="0"><select id="personalform-citybirth" name="PersonalForm[cityBirth]" size="4">
<option value="1" disabled>Moscu</option>
<option value="2">San Petersburgo</option>
<option value="3">Novosibirsk</option>
<option value="4" label="customText">Ekaterinburgo</option>
</select>

<div class="help-block"></div>
</div>
HTML;
        $html = Field::widget()
            ->config($this->data, 'cityBirth')
            ->listBox(
                $this->cities,
                ['unselect' => '0', 'options' => ['1' => ['disabled' => true], '4' => ['label' => 'customText']]]
            )
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }
}
