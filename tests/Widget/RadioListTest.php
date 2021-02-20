<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use Yiisoft\Form\Tests\Stub\PersonalForm;
use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Widget\RadioList;
use Yiisoft\Html\Widget\RadioList\RadioItem;

final class RadioListTest extends TestCase
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

    public function testActiveRadioList(): void
    {
        $this->data->cityBirth(2);

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[cityBirth]" value="">
<div id="personalform-citybirth">
<label><input type="radio" name="PersonalForm[cityBirth]" value="1"> Moscu</label>
<label><input type="radio" name="PersonalForm[cityBirth]" value="2" checked> San Petersburgo</label>
<label><input type="radio" name="PersonalForm[cityBirth]" value="3"> Novosibirsk</label>
<label><input type="radio" name="PersonalForm[cityBirth]" value="4"> Ekaterinburgo</label>
</div>
HTML;
        $html = RadioList::widget()
            ->config($this->data, 'cityBirth')
            ->items($this->cities)
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testActiveRadioListOptions(): void
    {
        $this->data->cityBirth(4);

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[cityBirth]" value="">
<div id="personalform-citybirth" class="customClass">
<label><input type="radio" name="PersonalForm[cityBirth]" value="1"> Moscu</label>
<label><input type="radio" name="PersonalForm[cityBirth]" value="2"> San Petersburgo</label>
<label><input type="radio" name="PersonalForm[cityBirth]" value="3"> Novosibirsk</label>
<label><input type="radio" name="PersonalForm[cityBirth]" value="4" checked> Ekaterinburgo</label>
</div>
HTML;
        $html = RadioList::widget()
            ->config($this->data, 'cityBirth', ['class' => 'customClass'])
            ->items($this->cities)
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testActiveRadioListItem(): void
    {
        $this->data->cityBirth(3);

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[cityBirth]" value="">
<div id="personalform-citybirth">
<div class='col-sm-12'><label><input tabindex='0' class='book' type='checkbox'  name='PersonalForm[cityBirth]' value='1'> Moscu</label></div>
<div class='col-sm-12'><label><input tabindex='1' class='book' type='checkbox'  name='PersonalForm[cityBirth]' value='2'> San Petersburgo</label></div>
<div class='col-sm-12'><label><input tabindex='2' class='book' type='checkbox' checked name='PersonalForm[cityBirth]' value='3'> Novosibirsk</label></div>
<div class='col-sm-12'><label><input tabindex='3' class='book' type='checkbox'  name='PersonalForm[cityBirth]' value='4'> Ekaterinburgo</label></div>
</div>
HTML;
        $html = RadioList::widget()
            ->config($this->data, 'cityBirth')
            ->items($this->cities)
            ->item(static function (RadioItem $item) {
                $check = $item->checked ? 'checked' : '';
                return "<div class='col-sm-12'><label><input tabindex='{$item->index}' class='book' type='checkbox' {$check} name='{$item->name}' value='{$item->value}'> {$item->label}</label></div>";
            })
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testActiveRadioListItemOptions(): void
    {
        $this->data->cityBirth(3);

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[cityBirth]" value="">
<div id="personalform-citybirth">
<label><input type="radio" class="itemClass" name="PersonalForm[cityBirth]" value="1"> Moscu</label>
<label><input type="radio" class="itemClass" name="PersonalForm[cityBirth]" value="2"> San Petersburgo</label>
<label><input type="radio" class="itemClass" name="PersonalForm[cityBirth]" value="3" checked> Novosibirsk</label>
<label><input type="radio" class="itemClass" name="PersonalForm[cityBirth]" value="4"> Ekaterinburgo</label>
</div>
HTML;
        $html = RadioList::widget()
            ->config($this->data, 'cityBirth')
            ->items($this->cities)
            ->itemOptions(['class' => 'itemClass'])
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testActiveRadioListNoEncode(): void
    {
        $this->data->cityBirth(4);
        $this->cities = [
            '1' => '&#127961; ' . 'Moscu',
            '2' => '&#127961; ' . 'San Petersburgo',
            '3' => '&#127961; ' . 'Novosibirsk',
            '4' => '&#127961; ' . 'Ekaterinburgo',
        ];

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[cityBirth]" value="">
<div id="personalform-citybirth">
<label><input type="radio" name="PersonalForm[cityBirth]" value="1"> &#127961; Moscu</label>
<label><input type="radio" name="PersonalForm[cityBirth]" value="2"> &#127961; San Petersburgo</label>
<label><input type="radio" name="PersonalForm[cityBirth]" value="3"> &#127961; Novosibirsk</label>
<label><input type="radio" name="PersonalForm[cityBirth]" value="4" checked> &#127961; Ekaterinburgo</label>
</div>
HTML;
        $html = RadioList::widget()
            ->config($this->data, 'cityBirth')
            ->items($this->cities)
            ->noEncode()
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testActiveRadioListNoUnselect(): void
    {
        $this->data->cityBirth(1);

        $expected = <<<'HTML'
<div id="personalform-citybirth">
<label><input type="radio" name="PersonalForm[cityBirth]" value="1" checked> Moscu</label>
<label><input type="radio" name="PersonalForm[cityBirth]" value="2"> San Petersburgo</label>
<label><input type="radio" name="PersonalForm[cityBirth]" value="3"> Novosibirsk</label>
<label><input type="radio" name="PersonalForm[cityBirth]" value="4"> Ekaterinburgo</label>
</div>
HTML;
        $html = RadioList::widget()
            ->config($this->data, 'cityBirth')
            ->items($this->cities)
            ->noUnselect()
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testActiveRadioListSeparator(): void
    {
        $this->data->cityBirth(1);

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[cityBirth]" value="">
<div id="personalform-citybirth">
<label><input type="radio" name="PersonalForm[cityBirth]" value="1" checked> Moscu</label>&#9866;<label><input type="radio" name="PersonalForm[cityBirth]" value="2"> San Petersburgo</label>&#9866;<label><input type="radio" name="PersonalForm[cityBirth]" value="3"> Novosibirsk</label>&#9866;<label><input type="radio" name="PersonalForm[cityBirth]" value="4"> Ekaterinburgo</label>
</div>
HTML;
        $html = RadioList::widget()
            ->config($this->data, 'cityBirth')
            ->items($this->cities)
            ->separator('&#9866;')
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testActiveRadioListTag(): void
    {
        $this->data->cityBirth(1);

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[cityBirth]" value="">
<label><input type="radio" name="PersonalForm[cityBirth]" value="1" checked> Moscu</label>
<label><input type="radio" name="PersonalForm[cityBirth]" value="2"> San Petersburgo</label>
<label><input type="radio" name="PersonalForm[cityBirth]" value="3"> Novosibirsk</label>
<label><input type="radio" name="PersonalForm[cityBirth]" value="4"> Ekaterinburgo</label>
HTML;
        $html = RadioList::widget()
            ->config($this->data, 'cityBirth')
            ->items($this->cities)
            ->tag()
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[cityBirth]" value="">
<span id="personalform-citybirth">
<label><input type="radio" name="PersonalForm[cityBirth]" value="1" checked> Moscu</label>
<label><input type="radio" name="PersonalForm[cityBirth]" value="2"> San Petersburgo</label>
<label><input type="radio" name="PersonalForm[cityBirth]" value="3"> Novosibirsk</label>
<label><input type="radio" name="PersonalForm[cityBirth]" value="4"> Ekaterinburgo</label>
</span>
HTML;
        $html = RadioList::widget()
            ->config($this->data, 'cityBirth')
            ->items($this->cities)
            ->tag('span')
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testActiveRadioListUnselect(): void
    {
        $this->data->cityBirth(1);

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[cityBirth]" value="0">
<div id="personalform-citybirth">
<label><input type="radio" name="PersonalForm[cityBirth]" value="1" checked> Moscu</label>
<label><input type="radio" name="PersonalForm[cityBirth]" value="2"> San Petersburgo</label>
<label><input type="radio" name="PersonalForm[cityBirth]" value="3"> Novosibirsk</label>
<label><input type="radio" name="PersonalForm[cityBirth]" value="4"> Ekaterinburgo</label>
</div>
HTML;
        $html = RadioList::widget()
            ->config($this->data, 'cityBirth')
            ->items($this->cities)
            ->unselect('0')
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }
}
