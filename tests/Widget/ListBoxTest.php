<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use Yiisoft\Form\Tests\Stub\PersonalForm;
use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Widget\ListBox;

final class ListBoxTest extends TestCase
{
    private PersonalForm $data;

    protected function setUp(): void
    {
        parent::setUp();

        $this->data = new PersonalForm();
    }

    public function testListBox(): void
    {
        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[cityBirth]" value="">
<select id="personalform-citybirth" name="PersonalForm[cityBirth]" size="4"></select>
HTML;
        $html = ListBox::widget()
            ->config($this->data, 'cityBirth')
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testListBoxOptions(): void
    {
        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[cityBirth]" value="">
<select id="personalform-citybirth" class="customClass" name="PersonalForm[cityBirth]" size="4">
<option value="1">Moscu</option>
<option value="2">San Petersburgo</option>
<option value="3">Novosibirsk</option>
<option value="4">Ekaterinburgo</option>
</select>
HTML;
        $html = ListBox::widget()
            ->config($this->data, 'cityBirth', ['class' => 'customClass'])
            ->items($this->getDataItems())
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testListBoxSelected(): void
    {
        $this->data->cityBirth(2);
        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[cityBirth]" value="">
<select id="personalform-citybirth" name="PersonalForm[cityBirth]" size="4">
<option value="1">Moscu</option>
<option value="2" selected>San Petersburgo</option>
<option value="3">Novosibirsk</option>
<option value="4">Ekaterinburgo</option>
</select>
HTML;
        $html = ListBox::widget()
            ->config($this->data, 'cityBirth')
            ->items($this->getDataItems())
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testListBoxSelectedArray(): void
    {
        $this->data->citiesVisited([2, 4]);
        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[citiesVisited]" value="">
<select id="personalform-citiesvisited" name="PersonalForm[citiesVisited]" size="4">
<option value="1">Moscu</option>
<option value="2" selected>San Petersburgo</option>
<option value="3">Novosibirsk</option>
<option value="4" selected>Ekaterinburgo</option>
</select>
HTML;
        $html = ListBox::widget()
            ->config($this->data, 'citiesVisited')
            ->items($this->getDataItems())
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testListBoxSelectedMultiple(): void
    {
        $this->data->cityBirth(2);

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[cityBirth]" value="">
<select id="personalform-citybirth" name="PersonalForm[cityBirth][]" multiple size="4">
<option value="1">Moscu</option>
<option value="2" selected>San Petersburgo</option>
<option value="3">Novosibirsk</option>
<option value="4">Ekaterinburgo</option>
</select>
HTML;
        $html = ListBox::widget()
            ->config($this->data, 'cityBirth')
            ->items($this->getDataItems())
            ->multiple()
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testListBoxSelectedMultipleArray(): void
    {
        $this->data->citiesVisited([2, 4]);

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[citiesVisited]" value="">
<select id="personalform-citiesvisited" name="PersonalForm[citiesVisited][]" multiple size="4">
<option value="1">Moscu</option>
<option value="2" selected>San Petersburgo</option>
<option value="3">Novosibirsk</option>
<option value="4" selected>Ekaterinburgo</option>
</select>
HTML;
        $html = ListBox::widget()
            ->config($this->data, 'citiesVisited')
            ->items($this->getDataItems())
            ->multiple()
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testListBoxSelectedMultipleObject(): void
    {
        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[cities]" value="">
<select id="personalform-cities" name="PersonalForm[cities]" size="4">
<option value="1" selected>Moscu</option>
<option value="2">San Petersburgo</option>
<option value="3" selected>Novosibirsk</option>
<option value="4">Ekaterinburgo</option>
</select>
HTML;
        $this->data->cities(new \ArrayObject([1, 3]));
        $html = ListBox::widget()
            ->config($this->data, 'cities')
            ->items($this->getDataItems())
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testListBoxSelectedArrayObjectKeysMultiple(): void
    {
        $this->data->citiesVisited(['value3']);

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[citiesVisited]" value="">
<select id="personalform-citiesvisited" name="PersonalForm[citiesVisited][]" multiple size="4">
<option value="0">zero</option>
<option value="1">one</option>
<option value="value3" selected>text3</option>
</select>
HTML;
        $html = ListBox::widget()
            ->config($this->data, 'citiesVisited')
            ->items($this->getDataItems3())
            ->multiple()
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);

        $this->data->cities(new \ArrayObject([0, 1]));

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[cities]" value="">
<select id="personalform-cities" name="PersonalForm[cities]" size="4">
<option value="0" selected>zero</option>
<option value="1" selected>one</option>
<option value="value3">text3</option>
</select>
HTML;
        $html = ListBox::widget()
            ->config($this->data, 'cities')
            ->items($this->getDataItems3())
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);

        $this->data->citiesVisited(['1', 'value3']);

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[citiesVisited]" value="">
<select id="personalform-citiesvisited" name="PersonalForm[citiesVisited]" size="4">
<option value="0">zero</option>
<option value="1" selected>one</option>
<option value="value3" selected>text3</option>
</select>
HTML;
        $html = ListBox::widget()
            ->config($this->data, 'citiesVisited')
            ->items($this->getDataItems3())
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testListBoxNoEncode(): void
    {
        /** default encode  */
        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[cityBirth]" value="">
<select id="personalform-citybirth" name="PersonalForm[cityBirth]" size="4">
<option value="value1&lt;&gt;">text1&lt;&gt;</option>
<option value="value  2">text  2</option>
</select>
HTML;
        $html = ListBox::widget()
            ->config($this->data, 'cityBirth')
            ->items($this->getDataItems2())
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[cityBirth]" value="">
<select id="personalform-citybirth" name="PersonalForm[cityBirth]" size="4">
<option value="value1&lt;&gt;">text1<></option>
<option value="value  2">text&nbsp;&nbsp;2</option>
</select>
HTML;
        /** disabled encode  */
        $html = ListBox::widget()
            ->config($this->data, 'cityBirth', ['encodeSpaces' => true, 'required' => false])
            ->items($this->getDataItems2())
            ->noEncode()
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[cityBirth]" value="">
<select id="personalform-citybirth" name="PersonalForm[cityBirth]" size="4">
<option value="value1&lt;&gt;">text1<></option>
<option value="value  2">text  2</option>
</select>
HTML;
        $html = ListBox::widget()
            ->config($this->data, 'cityBirth', ['encode' => false])
            ->items($this->getDataItems2())
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testListBoxEncodeSpaces(): void
    {
        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[cityBirth]" value="">
<select id="personalform-citybirth" name="PersonalForm[cityBirth]" size="4">
<option value="value1&lt;&gt;">text1&lt;&gt;</option>
<option value="value  2">text&nbsp;&nbsp;2</option>
</select>
HTML;
        $html = ListBox::widget()
            ->config($this->data, 'cityBirth')
            ->encodeSpaces()
            ->items($this->getDataItems2())
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[cityBirth]" value="">
<select id="personalform-citybirth" name="PersonalForm[cityBirth]" size="4">
<option value="value1&lt;&gt;">text1&lt;&gt;</option>
<option value="value  2">text&nbsp;&nbsp;2</option>
</select>
HTML;
        $html = ListBox::widget()
            ->config($this->data, 'cityBirth', ['encodeSpaces' => true])
            ->items($this->getDataItems2())
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[cityBirth]" value="">
<select id="personalform-citybirth" name="PersonalForm[cityBirth]" size="4">
<option value="value1&lt;&gt;">text1<></option>
<option value="value  2">text&nbsp;&nbsp;2</option>
</select>
HTML;
        $html = ListBox::widget()
            ->config($this->data, 'cityBirth')
            ->noEncode()
            ->encodeSpaces()
            ->items($this->getDataItems2())
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testListBoxGroups(): void
    {
        $groups = [
            '1' => ['label' => 'Russia'],
            '2' => ['label' => 'Chile'],
        ];

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[cityBirth]" value="">
<select id="personalform-citybirth" name="PersonalForm[cityBirth]" size="4">
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
        $html = ListBox::widget()
            ->config($this->data, 'cityBirth')
            ->items($this->getDataItemsGroup())
            ->groups($groups)
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testListBoxNoUnselect(): void
    {
        $expected = <<<'HTML'
<select id="personalform-citybirth" name="PersonalForm[cityBirth]" size="4">
<option value="1">Moscu</option>
<option value="2">San Petersburgo</option>
<option value="3">Novosibirsk</option>
<option value="4">Ekaterinburgo</option>
</select>
HTML;
        $html = ListBox::widget()
            ->config($this->data, 'cityBirth')
            ->items($this->getDataItems())
            ->noUnselect()
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testListBoxPrompt(): void
    {
        $prompt = [
            'text' => 'Select City Birth',
            'options' => [
                'value' => '0',
                'selected' => 'selected',
            ],
        ];

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[cityBirth]" value="">
<select id="personalform-citybirth" name="PersonalForm[cityBirth]" size="4">
<option value="0" selected>Select City Birth</option>
<option value="1">Moscu</option>
<option value="2">San Petersburgo</option>
<option value="3">Novosibirsk</option>
<option value="4">Ekaterinburgo</option>
</select>
HTML;
        $html = ListBox::widget()
            ->config($this->data, 'cityBirth')
            ->items($this->getDataItems())
            ->prompt($prompt)
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testListBoxRequired(): void
    {
        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[cityBirth]" value="">
<select id="personalform-citybirth" name="PersonalForm[cityBirth]" size="4" required>
<option value="1">Moscu</option>
<option value="2">San Petersburgo</option>
<option value="3">Novosibirsk</option>
<option value="4">Ekaterinburgo</option>
</select>
HTML;
        $html = ListBox::widget()
            ->config($this->data, 'cityBirth')
            ->items($this->getDataItems())
            ->required()
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testListBoxSizeWithPrompt(): void
    {
        $prompt = [
            'text' => 'Select City Birth',
            'options' => [
                'value' => '0',
                'selected' => 'selected',
            ],
        ];

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[cityBirth]" value="">
<select id="personalform-citybirth" name="PersonalForm[cityBirth]" size="1">
<option value="0" selected>Select City Birth</option>
<option value="1">Moscu</option>
<option value="2">San Petersburgo</option>
<option value="3">Novosibirsk</option>
<option value="4">Ekaterinburgo</option>
</select>
HTML;
        $html = ListBox::widget()
            ->config($this->data, 'cityBirth')
            ->items($this->getDataItems())
            ->prompt($prompt)
            ->size(1)
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testListBoxUnselect(): void
    {
        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[cityBirth]" value="0">
<select id="personalform-citybirth" name="PersonalForm[cityBirth]" size="4"></select>
HTML;
        $html = ListBox::widget()
            ->config($this->data, 'cityBirth')
            ->unselect('0')
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    private function getDataItems(): array
    {
        return [
            1 => 'Moscu',
            2 => 'San Petersburgo',
            3 => 'Novosibirsk',
            4 => 'Ekaterinburgo',
        ];
    }

    private function getDataItems2(): array
    {
        return [
            'value1<>' => 'text1<>',
            'value  2' => 'text  2',
        ];
    }

    private function getDataItems3(): array
    {
        return [
            'zero',
            'one',
            'value3' => 'text3',
        ];
    }

    private function getDataItemsGroup(): array
    {
        return [
            '1' => [
                '2' => ' Moscu',
                '3' => ' San Petersburgo',
                '4' => ' Novosibirsk',
                '5' => ' Ekaterinburgo',
            ],
            '2' => [
                '6' => 'Santiago',
                '7' => 'Concepcion',
                '8' => 'Chillan',
            ],
        ];
    }
}
