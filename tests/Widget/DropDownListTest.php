<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use Yiisoft\Form\FormModelInterface;
use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Tests\Stub\PersonalForm;
use Yiisoft\Form\Widget\DropDownList;

final class DropDownListTest extends TestCase
{
    private FormModelInterface $data;
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

    public function testDropDownList(): void
    {
        $this->data->cityBirth(2);

        $expected = <<<'HTML'
<select id="personalform-citybirth" name="PersonalForm[cityBirth]">
<option value="1">Moscu</option>
<option value="2" selected>San Petersburgo</option>
<option value="3">Novosibirsk</option>
<option value="4">Ekaterinburgo</option>
</select>
HTML;
        $html = DropDownList::widget()
            ->config($this->data, 'cityBirth')
            ->items($this->cities)
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testDropDownListOptions(): void
    {
        $this->data->cityBirth(3);

        $expected = <<<'HTML'
<select id="personalform-citybirth" class="customClass" name="PersonalForm[cityBirth]">
<option value="1">Moscu</option>
<option value="2">San Petersburgo</option>
<option value="3" selected>Novosibirsk</option>
<option value="4">Ekaterinburgo</option>
</select>
HTML;
        $html = DropDownList::widget()
            ->config($this->data, 'cityBirth', ['class' => 'customClass'])
            ->items($this->cities)
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testDropDownListNoEncode(): void
    {
        $this->cities = [
            '1' => '&#127961; ' . 'Moscu',
            '2' => '&#127961; ' . 'San Petersburgo',
            '3' => '&#127961; ' . 'Novosibirsk',
            '4' => '&#127961; ' . 'Ekaterinburgo'
        ];

        $this->data->cityBirth(1);

        $expected = <<<'HTML'
<select id="personalform-citybirth" name="PersonalForm[cityBirth]">
<option value="1" selected>&#127961; Moscu</option>
<option value="2">&#127961; San Petersburgo</option>
<option value="3">&#127961; Novosibirsk</option>
<option value="4">&#127961; Ekaterinburgo</option>
</select>
HTML;
        $html = DropDownList::widget()
            ->config($this->data, 'cityBirth')
            ->items($this->cities)
            ->noEncode()
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testDropDownListEncodeSpaces(): void
    {
        $this->cities = [
            '1' => ' Moscu',
            '2' => ' San Petersburgo',
            '3' => ' Novosibirsk',
            '4' => ' Ekaterinburgo'
        ];

        $this->data->cityBirth(1);

        $expected = <<<'HTML'
<select id="personalform-citybirth" name="PersonalForm[cityBirth]">
<option value="1" selected>&nbsp;Moscu</option>
<option value="2">&nbsp;San&nbsp;Petersburgo</option>
<option value="3">&nbsp;Novosibirsk</option>
<option value="4">&nbsp;Ekaterinburgo</option>
</select>
HTML;
        $html = DropDownList::widget()
            ->config($this->data, 'cityBirth')
            ->encodeSpaces()
            ->items($this->cities)
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testDropDownListGroups(): void
    {
        $groups = [
            '1' => ['label' => 'Russia'],
            '2' => ['label' => 'Chile']
        ];

        $this->cities = [
            '1' => [
                '2' => ' Moscu',
                '3' => ' San Petersburgo',
                '4' => ' Novosibirsk',
                '5' => ' Ekaterinburgo'
            ],
            '2' => [
                '6' => 'Santiago',
                '7' => 'Concepcion',
                '8' => 'Chillan'
            ]
        ];

        $this->data->cityBirth(1);

        $expected = <<<'HTML'
<select id="personalform-citybirth" name="PersonalForm[cityBirth]">
<optgroup label="Russia">
<option value="2"> Moscu</option>
<option value="3"> San Petersburgo</option>
<option value="4"> Novosibirsk</option>
<option value="5"> Ekaterinburgo</option>
</optgroup>
<optgroup label="Chile">
<option value="6">Santiago</option>
<option value="7">Concepcion</option>
<option value="8">Chillan</option>
</optgroup>
</select>
HTML;
        $html = DropDownList::widget()
            ->config($this->data, 'cityBirth')
            ->items($this->cities)
            ->groups($groups)
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testDropDownListMultiple(): void
    {
        $this->data->cityBirth(4);

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[cityBirth]" value=""><select id="personalform-citybirth" name="PersonalForm[cityBirth][]" multiple size="4">
<option value="1">Moscu</option>
<option value="2">San Petersburgo</option>
<option value="3">Novosibirsk</option>
<option value="4" selected>Ekaterinburgo</option>
</select>
HTML;
        $html = DropDownList::widget()
            ->config($this->data, 'cityBirth')
            ->items($this->cities)
            ->multiple()
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testDropDownListPrompt(): void
    {
        $prompt = [
            'text' => 'Select City Birth',
            'options' => [
                'value' => '0',
                'selected' => 'selected'
            ],
        ];

        $expected = <<<'HTML'
<select id="personalform-citybirth" name="PersonalForm[cityBirth]">
<option value="0" selected="selected">Select City Birth</option>
<option value="1">Moscu</option>
<option value="2">San Petersburgo</option>
<option value="3">Novosibirsk</option>
<option value="4">Ekaterinburgo</option>
</select>
HTML;
        $html = DropDownList::widget()
            ->config($this->data, 'cityBirth')
            ->items($this->cities)
            ->prompt($prompt)
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testDropDownListRequired(): void
    {
        $expected = <<<'HTML'
<select id="personalform-citybirth" name="PersonalForm[cityBirth]" required>
<option value="1">Moscu</option>
<option value="2">San Petersburgo</option>
<option value="3">Novosibirsk</option>
<option value="4">Ekaterinburgo</option>
</select>
HTML;
        $html = DropDownList::widget()
            ->config($this->data, 'cityBirth')
            ->items($this->cities)
            ->required()
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testDropDownListSizeWithMultiple(): void
    {
        $this->data->cityBirth(2);

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[cityBirth]" value=""><select id="personalform-citybirth" name="PersonalForm[cityBirth][]" multiple size="3">
<option value="1">Moscu</option>
<option value="2" selected>San Petersburgo</option>
<option value="3">Novosibirsk</option>
<option value="4">Ekaterinburgo</option>
</select>
HTML;
        $html = DropDownList::widget()
            ->config($this->data, 'cityBirth')
            ->items($this->cities)
            ->multiple()
            ->size(3)
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testDropDownListUnselectWithMultiple(): void
    {
        $this->data->cityBirth(2);

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[cityBirth]" value="0"><select id="personalform-citybirth" name="PersonalForm[cityBirth][]" multiple size="4">
<option value="1">Moscu</option>
<option value="2" selected>San Petersburgo</option>
<option value="3">Novosibirsk</option>
<option value="4">Ekaterinburgo</option>
</select>
HTML;
        $html = DropDownList::widget()
            ->config($this->data, 'cityBirth')
            ->items($this->cities)
            ->multiple()
            ->unselect('0')
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }
}
