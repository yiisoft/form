<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Tests\Stub\PersonalForm;
use Yiisoft\Form\Widget\Field;

final class FieldDropDownListTest extends TestCase
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
            '4' => 'Ekaterinburgo'
        ];
    }

    public function testFieldDropDownList(): void
    {
        $expected = <<<'HTML'
<div class="form-group field-personalform-citybirth">
<label class="control-label" for="personalform-citybirth">City Birth</label>
<select id="personalform-citybirth" class="form-control" name="PersonalForm[cityBirth]">
<option value="1">Moscu</option>
<option value="2">San Petersburgo</option>
<option value="3">Novosibirsk</option>
<option value="4">Ekaterinburgo</option>
</select>

<div class="help-block"></div>
</div>
HTML;
        $html = Field::widget()
            ->config($this->data, 'cityBirth')
            ->dropDownList($this->cities)
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testFieldDropDownListPromptWithLabelCustom(): void
    {
        $expected = <<<'HTML'
<div class="form-group field-personalform-citybirth">
<label class="control-label customLabelClass" for="personalform-citybirth">City Birth:</label>
<select id="personalform-citybirth" class="form-control" name="PersonalForm[cityBirth]">
<option value="0" selected="selected">Select City Birth</option>
<option value="1">Moscu</option>
<option value="2">San Petersburgo</option>
<option value="3">Novosibirsk</option>
<option value="4">Ekaterinburgo</option>
</select>

<div class="help-block"></div>
</div>
HTML;
        $html = Field::widget()
            ->config($this->data, 'cityBirth')
            ->label(true, ['class' => 'customLabelClass'], 'City Birth:')
            ->dropDownList($this->cities, [
                'prompt' => [
                    'text' => 'Select City Birth',
                    'options' => [
                        'value' => '0',
                        'selected' => 'selected'
                    ],
                ],
            ])
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testFieldDropDownListPromptWithGroup(): void
    {
        $this->cities = [
            '1' => [
                '1' => 'Santiago',
                '2' => 'Concepcion',
                '3' => 'Chillan',
            ],
            '2' => [
                '4' => 'Moscu',
                '5' => 'San Petersburgo',
                '6' => 'Novosibirsk',
                '7' => 'Ekaterinburgo'
            ],
        ];

        $expected = <<<'HTML'
<div class="form-group field-personalform-citybirth">
<label class="control-label" for="personalform-citybirth">City Birth</label>
<select id="personalform-citybirth" class="form-control" name="PersonalForm[cityBirth]">
<option value="0" selected="selected">Select City Birth</option>
<optgroup label="Chile">
<option value="1">Santiago</option>
<option value="2">Concepcion</option>
<option value="3">Chillan</option>
</optgroup>
<optgroup label="Russia">
<option value="4">Moscu</option>
<option value="5">San Petersburgo</option>
<option value="6">Novosibirsk</option>
<option value="7">Ekaterinburgo</option>
</optgroup>
</select>

<div class="help-block"></div>
</div>
HTML;
        $html = Field::widget()
            ->config($this->data, 'cityBirth')
            ->dropDownList($this->cities, [
                'groups' => [
                    '1' => ['label' => 'Chile'],
                    '2' => ['label' => 'Russia']
                ],
                'prompt' => [
                    'text' => 'Select City Birth',
                    'options' => [
                        'value' => '0',
                        'selected' => 'selected'
                    ],
                ],
            ])
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testFieldDropDownListPromptMultipleAnyLabel(): void
    {
        $expected = <<<'HTML'
<div class="form-group field-personalform-citybirth">

<input type="hidden" name="PersonalForm[cityBirth]" value="0"><select id="personalform-citybirth" class="form-control" name="PersonalForm[cityBirth][]" multiple size="5">
<option value="0" selected="selected">Select City Birth</option>
<option value="1">Moscu</option>
<option value="2">San Petersburgo</option>
<option value="3">Novosibirsk</option>
<option value="4">Ekaterinburgo</option>
</select>

<div class="help-block"></div>
</div>
HTML;
        $html = Field::widget()
            ->config($this->data, 'cityBirth')
            ->label(false)
            ->dropDownList($this->cities, [
                'prompt' => [
                    'text' => 'Select City Birth',
                    'options' => [
                        'value' => '0',
                        'selected' => 'selected'
                    ],
                ],
                'multiple' => true,
                'unselect' => '0',
                'size' => 5
            ])
            ->run();
        $this->assertEquals($expected, $html);
    }
}
