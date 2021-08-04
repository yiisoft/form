<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Tests\Stub\PersonalForm;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Widget\DropDownList;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class DropDownListTest extends TestCase
{
    use TestTrait;

    private PersonalForm $data;
    private array $cities = [];

    public function testGroups(): void
    {
        $groups = [
            '1' => ['label' => 'Russia'],
            '2' => ['label' => 'Chile'],
        ];

        $this->cities = [
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
        $this->assertEqualsWithoutLE(
            $expected,
            DropDownList::widget()->config($this->data, 'cityBirth')->items($this->cities)->groups($groups)->render(),
        );
    }

    public function testGroupsItemsAttributes(): void
    {
        $groups = [
            '1' => ['class' => 'text-class', 'label' => 'Russia'],
            '2' => ['class' => 'text-class', 'label' => 'Chile'],
        ];

        $this->cities = [
            '1' => [
                '2' => 'Moscu',
                '3' => 'San Petersburgo',
                '4' => 'Novosibirsk',
                '5' => 'Ekaterinburgo',
            ],
            '2' => [
                '6' => 'Santiago',
                '7' => 'Concepcion',
                '8' => 'Chillan',
            ],
        ];

        $this->data->setAttribute('cityBirth', 1);

        $html = DropDownList::widget()
            ->config($this->data, 'cityBirth')
            ->items($this->cities)
            ->itemsAttributes(['2' => ['disabled' => true]])
            ->groups($groups)
            ->render();
        $expected = <<<'HTML'
        <select id="personalform-citybirth" name="PersonalForm[cityBirth]">
        <optgroup class="text-class" label="Russia">
        <option value="2" disabled>Moscu</option>
        <option value="3">San Petersburgo</option>
        <option value="4">Novosibirsk</option>
        <option value="5">Ekaterinburgo</option>
        </optgroup>
        <optgroup class="text-class" label="Chile">
        <option value="6">Santiago</option>
        <option value="7">Concepcion</option>
        <option value="8">Chillan</option>
        </optgroup>
        </select>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testMultiple(): void
    {
        $this->data->cityBirth(4);

        $expected = <<<'HTML'
        <input type="hidden" name="PersonalForm[cityBirth]" value="">
        <select id="personalform-citybirth" name="PersonalForm[cityBirth][]" multiple size="4">
        <option value="1">Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4" selected>Ekaterinburgo</option>
        </select>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            DropDownList::widget()->config($this->data, 'cityBirth')->items($this->cities)->multiple()->render(),
        );
    }

    public function testOptionsDataEncode(): void
    {
        $this->data->setAttribute('cityBirth', 3);
        $cities = [
            '1' => '<b>Moscu</b>',
            '2' => 'San Petersburgo',
            '3' => 'Novosibirsk',
            '4' => 'Ekaterinburgo',
        ];

        $expected = <<<'HTML'
        <select id="personalform-citybirth" name="PersonalForm[cityBirth]">
        <option value="1">&lt;b&gt;Moscu&lt;/b&gt;</option>
        <option value="2">San Petersburgo</option>
        <option value="3" selected>Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            DropDownList::widget()->config($this->data, 'cityBirth')->optionsData($cities, true)->render(),
        );
    }

    public function testPrompt(): void
    {
        $prompt = [
            'text' => 'Select City Birth',
            'attributes' => [
                'value' => '0',
                'selected' => 'selected',
            ],
        ];

        $expected = <<<'HTML'
        <select id="personalform-citybirth" name="PersonalForm[cityBirth]">
        <option value="0" selected>Select City Birth</option>
        <option value="1">Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            DropDownList::widget()->config($this->data, 'cityBirth')->items($this->cities)->prompt($prompt)->render(),
        );
    }

    public function testRender(): void
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
        $this->assertEqualsWithoutLE(
            $expected,
            DropDownList::widget()->config($this->data, 'cityBirth')->items($this->cities)->render(),
        );
    }

    public function testRequired(): void
    {
        $expected = <<<'HTML'
        <select id="personalform-citybirth" name="PersonalForm[cityBirth]" required>
        <option value="1">Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            DropDownList::widget()->config($this->data, 'cityBirth')->items($this->cities)->required()->render(),
        );
    }

    public function testSizeWithMultiple(): void
    {
        $this->data->cityBirth(2);

        $expected = <<<'HTML'
        <input type="hidden" name="PersonalForm[cityBirth]" value="">
        <select id="personalform-citybirth" name="PersonalForm[cityBirth][]" multiple size="3">
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
            ->render();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testUnselectValueWithMultiple(): void
    {
        $this->data->cityBirth(2);

        $expected = <<<'HTML'
        <input type="hidden" name="PersonalForm[cityBirth]" value="0">
        <select id="personalform-citybirth" name="PersonalForm[cityBirth][]" multiple size="4">
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
            ->unselectValue('0')
            ->render();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer(), []);

        $this->data = new PersonalForm();
        $this->cities = [
            '1' => 'Moscu',
            '2' => 'San Petersburgo',
            '3' => 'Novosibirsk',
            '4' => 'Ekaterinburgo',
        ];
    }
}
