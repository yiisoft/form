<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Tests\Stub\PersonalForm;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Widget\CheckBoxList;
use Yiisoft\Html\Widget\CheckboxList\CheckboxItem;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class CheckboxListTest extends TestCase
{
    use TestTrait;

    public function testContainerAttributes(): void
    {
        $data = new PersonalForm();
        $data->sex(0);

        $html = CheckboxList::widget()
            ->config($data, 'sex')
            ->containerAttributes(['class' => 'test-class'])
            ->items(['Female', 'Male'])
            ->render();
        $expected = <<<'HTML'
        <input type="hidden" name="PersonalForm[sex]" value="">
        <div id="personalform-sex" class="test-class">
        <label><input type="checkbox" name="PersonalForm[sex][]" value="0" checked> Female</label>
        <label><input type="checkbox" name="PersonalForm[sex][]" value="1"> Male</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testContainerTag(): void
    {
        $data = new PersonalForm();
        $data->sex(0);

        $expected = <<<'HTML'
        <input type="hidden" name="PersonalForm[sex]" value="">
        <tag-test id="personalform-sex">
        <label><input type="checkbox" name="PersonalForm[sex][]" value="0" checked> Female</label>
        <label><input type="checkbox" name="PersonalForm[sex][]" value="1"> Male</label>
        </tag-test>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            CheckboxList::widget()->config($data, 'sex')->containerTag('tag-test')->items(['Female', 'Male'])->render(),
        );
    }

    public function testDisabled(): void
    {
        $data = new PersonalForm();
        $data->sex(0);

        $expected = <<<'HTML'
        <input type="hidden" name="PersonalForm[sex]" value="" disabled>
        <div id="personalform-sex">
        <label><input type="checkbox" name="PersonalForm[sex][]" value="0" checked disabled> Female</label>
        <label><input type="checkbox" name="PersonalForm[sex][]" value="1" disabled> Male</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            CheckboxList::widget()->config($data, 'sex')->items(['Female', 'Male'])->disabled()->render(),
        );
    }

    public function testForceUncheckedValueWithNull(): void
    {
        $data = new PersonalForm();
        $data->terms(true);

        $html = CheckBoxList::widget()
            ->config($data, 'terms')
            ->forceUncheckedValue(null)
            ->items(['Female', 'Male'])
            ->render();
        $expected = <<<'HTML'
        <div id="personalform-terms">
        <label><input type="checkbox" name="PersonalForm[terms][]" value="0"> Female</label>
        <label><input type="checkbox" name="PersonalForm[terms][]" value="1" checked> Male</label>
        </div>
        HTML;
        $this->assertSame($expected, $html);
    }

    public function testItemsAttributes(): void
    {
        $data = new PersonalForm();
        $data->sex(0);

        $expected = <<<'HTML'
        <input type="hidden" name="PersonalForm[sex]" value="">
        <div id="personalform-sex">
        <label><input type="checkbox" class="test-class" name="PersonalForm[sex][]" value="0" checked> Female</label>
        <label><input type="checkbox" class="test-class" name="PersonalForm[sex][]" value="1"> Male</label>
        </div>
        HTML;
        $html = CheckboxList::widget()
            ->config($data, 'sex')
            ->items(['Female', 'Male'])
            ->itemsAttributes(['class' => 'test-class'])
            ->render();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testItemFormater(): void
    {
        $data = new PersonalForm();
        $data->sex(0);

        $expected = <<<'HTML'
        <input type="hidden" name="PersonalForm[sex]" value="">
        <div id="personalform-sex">
        <div class='test-class'><label><input tabindex='0' class='test-class' type='checkbox' checked name='PersonalForm[sex][]' value='0'> Female</label></div>
        <div class='test-class'><label><input tabindex='1' class='test-class' type='checkbox'  name='PersonalForm[sex][]' value='1'> Male</label></div>
        </div>
        HTML;
        $html = CheckboxList::widget()
            ->config($data, 'sex')
            ->items(['Female', 'Male'])
            ->itemFormater(static function (CheckboxItem $item) {
                $check = $item->checked ? 'checked' : '';
                return "<div class='test-class'><label><input tabindex='{$item->index}' class='test-class' type='checkbox' {$check} name='{$item->name}' value='{$item->value}'> {$item->label}</label></div>";
            })
            ->render();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testReadOnly(): void
    {
        $data = new PersonalForm();
        $data->sex(1);

        $expected = <<<'HTML'
        <input type="hidden" name="PersonalForm[sex]" value="">
        <div id="personalform-sex">
        <label><input type="checkbox" name="PersonalForm[sex][]" value="0" readonly> Female</label>
        <label><input type="checkbox" name="PersonalForm[sex][]" value="1" checked readonly> Male</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            CheckboxList::widget()->config($data, 'sex')->items(['Female', 'Male'])->readOnly()->render(),
        );
    }

    public function testRender(): void
    {
        $data = new PersonalForm();
        $data->sex(1);

        $expected = <<<'HTML'
        <input type="hidden" name="PersonalForm[sex]" value="">
        <div id="personalform-sex">
        <label><input type="checkbox" name="PersonalForm[sex][]" value="0"> Female</label>
        <label><input type="checkbox" name="PersonalForm[sex][]" value="1" checked> Male</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            CheckboxList::widget()->config($data, 'sex')->items(['Female', 'Male'])->render(),
        );
    }

    public function testSeparator(): void
    {
        $data = new PersonalForm();
        $data->sex(1);

        $expected = <<<'HTML'
        <input type="hidden" name="PersonalForm[sex]" value="">
        <div id="personalform-sex">
        <label><input type="checkbox" name="PersonalForm[sex][]" value="0"> Female</label>&#9866;<label><input type="checkbox" name="PersonalForm[sex][]" value="1" checked> Male</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            CheckboxList::widget()->config($data, 'sex')->items(['Female', 'Male'])->separator('&#9866;')->render(),
        );
    }

    public function testValueIterable(): void
    {
        $data = new PersonalForm();
        $data->setAttribute('citiesVisited', [0, 1]);

        $expected = <<<'HTML'
        <input type="hidden" name="PersonalForm[citiesVisited]" value="">
        <div id="personalform-citiesvisited">
        <label><input type="checkbox" name="PersonalForm[citiesVisited][]" value="0" checked> Moscu</label>
        <label><input type="checkbox" name="PersonalForm[citiesVisited][]" value="1" checked> San Petesburgo</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            CheckboxList::widget()->config($data, 'citiesVisited')->items(['Moscu', 'San Petesburgo'])->render(),
        );
    }

    public function testWithoutContainer(): void
    {
        $data = new PersonalForm();
        $data->sex(1);

        $html = CheckboxList::widget()
            ->config($data, 'sex', ['forceUncheckedValue' => null])
            ->items(['Female', 'Male'])
            ->withoutContainer()
            ->render();
        $expected = <<<'HTML'
        <label><input type="checkbox" name="PersonalForm[sex][]" value="0"> Female</label>
        <label><input type="checkbox" name="PersonalForm[sex][]" value="1" checked> Male</label>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer(), []);
    }
}
