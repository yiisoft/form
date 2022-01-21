<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;
use Yiisoft\Form\Tests\TestSupport\Form\TypeForm;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Widget\RadioList;
use Yiisoft\Html\Widget\RadioList\RadioItem;

final class RadioListTest extends TestCase
{
    use TestTrait;

    /** @var string[] */
    private array $cities = ['1' => 'Moscu', '2' => 'San Petersburgo', '3' => 'Novosibirsk', '4' => 'Ekaterinburgo'];

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testAutofocus(): void
    {
        $expected = <<<HTML
        <div id="typeform-string" autofocus>
        <label><input type="radio" name="TypeForm[string]" value="1"> Moscu</label>
        <label><input type="radio" name="TypeForm[string]" value="2"> San Petersburgo</label>
        <label><input type="radio" name="TypeForm[string]" value="3"> Novosibirsk</label>
        <label><input type="radio" name="TypeForm[string]" value="4"> Ekaterinburgo</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            RadioList::widget()->autofocus()->for(new TypeForm(), 'string')->items($this->cities)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testContainerAttributes(): void
    {
        $expected = <<<HTML
        <div id="typeform-int" class="test-class">
        <label><input type="radio" name="TypeForm[int]" value="1"> Moscu</label>
        <label><input type="radio" name="TypeForm[int]" value="2"> San Petersburgo</label>
        <label><input type="radio" name="TypeForm[int]" value="3"> Novosibirsk</label>
        <label><input type="radio" name="TypeForm[int]" value="4"> Ekaterinburgo</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            RadioList::widget()
                ->for(new TypeForm(), 'int')
                ->containerAttributes(['class' => 'test-class'])
                ->items($this->cities)
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testContainerTag(): void
    {
        $expected = <<<HTML
        <tag-test id="typeform-int">
        <label><input type="radio" name="TypeForm[int]" value="1"> Moscu</label>
        <label><input type="radio" name="TypeForm[int]" value="2"> San Petersburgo</label>
        <label><input type="radio" name="TypeForm[int]" value="3"> Novosibirsk</label>
        <label><input type="radio" name="TypeForm[int]" value="4"> Ekaterinburgo</label>
        </tag-test>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            RadioList::widget()->for(new TypeForm(), 'int')->containerTag('tag-test')->items($this->cities)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testContainerTagWithNull(): void
    {
        $expected = <<<HTML
        <label><input type="radio" name="TypeForm[int]" value="1"> Moscu</label>
        <label><input type="radio" name="TypeForm[int]" value="2"> San Petersburgo</label>
        <label><input type="radio" name="TypeForm[int]" value="3"> Novosibirsk</label>
        <label><input type="radio" name="TypeForm[int]" value="4"> Ekaterinburgo</label>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            RadioList::widget()->for(new TypeForm(), 'int')->containerTag()->items($this->cities)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testDisabled(): void
    {
        $expected = <<<HTML
        <div id="typeform-string">
        <label><input type="radio" name="TypeForm[string]" value="1" disabled> Moscu</label>
        <label><input type="radio" name="TypeForm[string]" value="2" disabled> San Petersburgo</label>
        <label><input type="radio" name="TypeForm[string]" value="3" disabled> Novosibirsk</label>
        <label><input type="radio" name="TypeForm[string]" value="4" disabled> Ekaterinburgo</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            RadioList::widget()->disabled()->for(new TypeForm(), 'string')->items($this->cities)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testId(): void
    {
        $expected = <<<HTML
        <div id="id-test">
        <label><input type="radio" name="TypeForm[int]" value="1"> Moscu</label>
        <label><input type="radio" name="TypeForm[int]" value="2"> San Petersburgo</label>
        <label><input type="radio" name="TypeForm[int]" value="3"> Novosibirsk</label>
        <label><input type="radio" name="TypeForm[int]" value="4"> Ekaterinburgo</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            RadioList::widget()->for(new TypeForm(), 'int')->id('id-test')->items($this->cities)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testIndividualItemsAttributes(): void
    {
        // Set disabled `[1 => ['disabled' => 'true']]`, `[2 => ['class' => 'test-class']]`.
        $expected = <<<HTML
        <div id="typeform-int">
        <label><input type="radio" name="TypeForm[int]" value="1" disabled> Moscu</label>
        <label><input type="radio" class="test-class" name="TypeForm[int]" value="2"> San Petersburgo</label>
        <label><input type="radio" name="TypeForm[int]" value="3"> Novosibirsk</label>
        <label><input type="radio" name="TypeForm[int]" value="4"> Ekaterinburgo</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            RadioList::widget()
                ->for(new TypeForm(), 'int')
                ->individualItemsAttributes([1 => ['disabled' => true], 2 => ['class' => 'test-class']])
                ->items($this->cities)
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testImmutability(): void
    {
        $radioList = RadioList::widget();
        $this->assertNotSame($radioList, $radioList->autofocus());
        $this->assertNotSame($radioList, $radioList->containerAttributes([]));
        $this->assertNotSame($radioList, $radioList->containerTag());
        $this->assertNotSame($radioList, $radioList->id(null));
        $this->assertNotSame($radioList, $radioList->individualItemsAttributes());
        $this->assertNotSame($radioList, $radioList->items());
        $this->assertNotSame($radioList, $radioList->itemsAttributes());
        $this->assertNotSame($radioList, $radioList->itemsFormatter(null));
        $this->assertNotSame($radioList, $radioList->itemsFromValues());
        $this->assertNotSame($radioList, $radioList->separator());
        $this->assertNotSame($radioList, $radioList->tabindex(1));
        $this->assertNotSame($radioList, $radioList->uncheckValue(''));
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testItemsFormater(): void
    {
        $expected = <<<HTML
        <div id="typeform-int">
        <div class='col-sm-12'><label><input type='radio' name='TypeForm[int]' class='test-class' value='1' tabindex='0'> Moscu</label></div>
        <div class='col-sm-12'><label><input type='radio' name='TypeForm[int]' class='test-class' value='2' tabindex='1'> San Petersburgo</label></div>
        <div class='col-sm-12'><label><input type='radio' name='TypeForm[int]' class='test-class' value='3' tabindex='2'> Novosibirsk</label></div>
        <div class='col-sm-12'><label><input type='radio' name='TypeForm[int]' class='test-class' value='4' tabindex='3'> Ekaterinburgo</label></div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            RadioList::widget()
                ->for(new TypeForm(), 'int')
                ->items($this->cities)
                ->itemsFormatter(static function (RadioItem $item) {
                    return $item->checked
                        ? "<div class='col-sm-12'><label><input type='radio' name='$item->name' class='test-class' value='$item->value' tabindex='$item->index' checked> $item->label</label></div>"
                        : "<div class='col-sm-12'><label><input type='radio' name='$item->name' class='test-class' value='$item->value' tabindex='$item->index'> $item->label</label></div>";
                })
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testItemsFromValues(): void
    {
        $formModel = new TypeForm();

        // Value string `Novosibirsk`.
        $formModel->setAttribute('string', 'Novosibirsk');

        $expected = <<<HTML
        <div id="typeform-string">
        <label><input type="radio" name="TypeForm[string]" value="Moscu"> Moscu</label>
        <label><input type="radio" name="TypeForm[string]" value="San Petersburgo"> San Petersburgo</label>
        <label><input type="radio" name="TypeForm[string]" value="Novosibirsk" checked> Novosibirsk</label>
        <label><input type="radio" name="TypeForm[string]" value="Ekaterinburgo"> Ekaterinburgo</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            RadioList::widget()->for($formModel, 'string')->itemsFromValues($this->cities)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testName(): void
    {
        $expected = <<<HTML
        <div id="typeform-string">
        <label><input type="radio" name="name-test" value="1"> Moscu</label>
        <label><input type="radio" name="name-test" value="2"> San Petersburgo</label>
        <label><input type="radio" name="name-test" value="3"> Novosibirsk</label>
        <label><input type="radio" name="name-test" value="4"> Ekaterinburgo</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            RadioList::widget()->for(new TypeForm(), 'string')->items($this->cities)->name('name-test')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRender(): void
    {
        $expected = <<<HTML
        <div id="typeform-int">
        <label><input type="radio" name="TypeForm[int]" value="1"> Moscu</label>
        <label><input type="radio" name="TypeForm[int]" value="2"> San Petersburgo</label>
        <label><input type="radio" name="TypeForm[int]" value="3"> Novosibirsk</label>
        <label><input type="radio" name="TypeForm[int]" value="4"> Ekaterinburgo</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            RadioList::widget()->for(new TypeForm(), 'int')->items($this->cities)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testSeparator(): void
    {
        $expected = <<<HTML
        <div id="typeform-int">
        <label><input type="radio" name="TypeForm[int]" value="1"> Moscu</label>
        <label><input type="radio" name="TypeForm[int]" value="2"> San Petersburgo</label>
        <label><input type="radio" name="TypeForm[int]" value="3"> Novosibirsk</label>
        <label><input type="radio" name="TypeForm[int]" value="4"> Ekaterinburgo</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            RadioList::widget()->for(new TypeForm(), 'int')->items($this->cities)->separator(PHP_EOL)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testTabIndex(): void
    {
        $expected = <<<HTML
        <div id="typeform-int" tabindex="1">
        <label><input type="radio" name="TypeForm[int]" value="1"> Moscu</label>
        <label><input type="radio" name="TypeForm[int]" value="2"> San Petersburgo</label>
        <label><input type="radio" name="TypeForm[int]" value="3"> Novosibirsk</label>
        <label><input type="radio" name="TypeForm[int]" value="4"> Ekaterinburgo</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            RadioList::widget()->for(new TypeForm(), 'int')->items($this->cities)->tabindex(1)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testUncheckValue(): void
    {
        $expected = <<<HTML
        <input type="hidden" name="TypeForm[int]" value="0">
        <div id="typeform-int">
        <label><input type="radio" name="TypeForm[int]" value="1"> Moscu</label>
        <label><input type="radio" name="TypeForm[int]" value="2"> San Petersburgo</label>
        <label><input type="radio" name="TypeForm[int]" value="3"> Novosibirsk</label>
        <label><input type="radio" name="TypeForm[int]" value="4"> Ekaterinburgo</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            RadioList::widget()->for(new TypeForm(), 'int')->items($this->cities)->uncheckValue(0)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValue(): void
    {
        // Value bool `false`.
        $expected = <<<HTML
        <div id="typeform-bool">
        <label><input type="radio" name="TypeForm[bool]" value="0" checked> Female</label>
        <label><input type="radio" name="TypeForm[bool]" value="1"> Male</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            RadioList::widget()
                ->for(new TypeForm(), 'bool')
                ->items([0 => 'Female', 1 => 'Male'])
                ->value(false)
                ->render(),
        );

        // Value bool `true`.
        $expected = <<<HTML
        <div id="typeform-bool">
        <label><input type="radio" name="TypeForm[bool]" value="0"> Female</label>
        <label><input type="radio" name="TypeForm[bool]" value="1" checked> Male</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            RadioList::widget()
                ->for(new TypeForm(), 'bool')
                ->items([0 => 'Female', 1 => 'Male'])
                ->value(true)
                ->render(),
        );

        // Value int `0`.
        $expected = <<<HTML
        <div id="typeform-int">
        <label><input type="radio" name="TypeForm[int]" value="1"> Moscu</label>
        <label><input type="radio" name="TypeForm[int]" value="2"> San Petersburgo</label>
        <label><input type="radio" name="TypeForm[int]" value="3"> Novosibirsk</label>
        <label><input type="radio" name="TypeForm[int]" value="4"> Ekaterinburgo</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            RadioList::widget()->for(new TypeForm(), 'int')->items($this->cities)->value(0)->render(),
        );

        // Value int `1`.
        $expected = <<<HTML
        <div id="typeform-int">
        <label><input type="radio" name="TypeForm[int]" value="1" checked> Moscu</label>
        <label><input type="radio" name="TypeForm[int]" value="2"> San Petersburgo</label>
        <label><input type="radio" name="TypeForm[int]" value="3"> Novosibirsk</label>
        <label><input type="radio" name="TypeForm[int]" value="4"> Ekaterinburgo</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            RadioList::widget()->for(new TypeForm(), 'int')->items($this->cities)->value(1)->render(),
        );

        // Value string '0'.
        $expected = <<<HTML
        <div id="typeform-string">
        <label><input type="radio" name="TypeForm[string]" value="1"> Moscu</label>
        <label><input type="radio" name="TypeForm[string]" value="2"> San Petersburgo</label>
        <label><input type="radio" name="TypeForm[string]" value="3"> Novosibirsk</label>
        <label><input type="radio" name="TypeForm[string]" value="4"> Ekaterinburgo</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            RadioList::widget()->for(new TypeForm(), 'string')->items($this->cities)->value('0')->render(),
        );

        // Value string '1'.
        $expected = <<<HTML
        <div id="typeform-string">
        <label><input type="radio" name="TypeForm[string]" value="1" checked> Moscu</label>
        <label><input type="radio" name="TypeForm[string]" value="2"> San Petersburgo</label>
        <label><input type="radio" name="TypeForm[string]" value="3"> Novosibirsk</label>
        <label><input type="radio" name="TypeForm[string]" value="4"> Ekaterinburgo</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            RadioList::widget()->for(new TypeForm(), 'string')->items($this->cities)->value('1')->render(),
        );

        // Value `null`.
        $expected = <<<HTML
        <div id="typeform-int">
        <label><input type="radio" name="TypeForm[int]" value="1"> Moscu</label>
        <label><input type="radio" name="TypeForm[int]" value="2"> San Petersburgo</label>
        <label><input type="radio" name="TypeForm[int]" value="3"> Novosibirsk</label>
        <label><input type="radio" name="TypeForm[int]" value="4"> Ekaterinburgo</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            RadioList::widget()->for(new TypeForm(), 'int')->items($this->cities)->value(null)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('RadioList widget value can not be an iterable or an object.');
        RadioList::widget()->for(new TypeForm(), 'array')->render();
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueWithForm(): void
    {
        $formModel = new TypeForm();

        // Value bool `false`.
        $formModel->setAttribute('int', false);

        $expected = <<<HTML
        <div id="typeform-int">
        <label><input type="radio" name="TypeForm[int]" value="0" checked> Female</label>
        <label><input type="radio" name="TypeForm[int]" value="1"> Male</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            RadioList::widget()->for($formModel, 'int')->items([0 => 'Female', 1 => 'Male'])->render(),
        );

        // Value bool `true`.
        $formModel->setAttribute('int', true);

        $expected = <<<HTML
        <div id="typeform-int">
        <label><input type="radio" name="TypeForm[int]" value="0"> Female</label>
        <label><input type="radio" name="TypeForm[int]" value="1" checked> Male</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            RadioList::widget()->for($formModel, 'int')->items([0 => 'Female', 1 => 'Male'])->render(),
        );

        // Value int `0`.
        $formModel->setAttribute('int', 0);

        $expected = <<<HTML
        <div id="typeform-int">
        <label><input type="radio" name="TypeForm[int]" value="1"> Moscu</label>
        <label><input type="radio" name="TypeForm[int]" value="2"> San Petersburgo</label>
        <label><input type="radio" name="TypeForm[int]" value="3"> Novosibirsk</label>
        <label><input type="radio" name="TypeForm[int]" value="4"> Ekaterinburgo</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            RadioList::widget()->for($formModel, 'int')->items($this->cities)->render(),
        );

        // Value int `1`.
        $formModel->setAttribute('int', 1);

        $expected = <<<HTML
        <div id="typeform-int">
        <label><input type="radio" name="TypeForm[int]" value="1" checked> Moscu</label>
        <label><input type="radio" name="TypeForm[int]" value="2"> San Petersburgo</label>
        <label><input type="radio" name="TypeForm[int]" value="3"> Novosibirsk</label>
        <label><input type="radio" name="TypeForm[int]" value="4"> Ekaterinburgo</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            RadioList::widget()->for($formModel, 'int')->items($this->cities)->render(),
        );

        // Value string '0'.
        $formModel->setAttribute('string', '0');

        $expected = <<<HTML
        <div id="typeform-string">
        <label><input type="radio" name="TypeForm[string]" value="1"> Moscu</label>
        <label><input type="radio" name="TypeForm[string]" value="2"> San Petersburgo</label>
        <label><input type="radio" name="TypeForm[string]" value="3"> Novosibirsk</label>
        <label><input type="radio" name="TypeForm[string]" value="4"> Ekaterinburgo</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            RadioList::widget()->for($formModel, 'string')->items($this->cities)->render(),
        );

        // Value string '1'.
        $formModel->setAttribute('string', '1');

        $expected = <<<HTML
        <div id="typeform-string">
        <label><input type="radio" name="TypeForm[string]" value="1" checked> Moscu</label>
        <label><input type="radio" name="TypeForm[string]" value="2"> San Petersburgo</label>
        <label><input type="radio" name="TypeForm[string]" value="3"> Novosibirsk</label>
        <label><input type="radio" name="TypeForm[string]" value="4"> Ekaterinburgo</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            RadioList::widget()->for($formModel, 'string')->items($this->cities)->render(),
        );

        // Value `null`.
        $formModel->setAttribute('int', null);

        $expected = <<<HTML
        <div id="typeform-int">
        <label><input type="radio" name="TypeForm[int]" value="1"> Moscu</label>
        <label><input type="radio" name="TypeForm[int]" value="2"> San Petersburgo</label>
        <label><input type="radio" name="TypeForm[int]" value="3"> Novosibirsk</label>
        <label><input type="radio" name="TypeForm[int]" value="4"> Ekaterinburgo</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            RadioList::widget()->for($formModel, 'int')->items($this->cities)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutId(): void
    {
        $expected = <<<HTML
        <div>
        <label><input type="radio" name="TypeForm[int]" value="1"> Moscu</label>
        <label><input type="radio" name="TypeForm[int]" value="2"> San Petersburgo</label>
        <label><input type="radio" name="TypeForm[int]" value="3"> Novosibirsk</label>
        <label><input type="radio" name="TypeForm[int]" value="4"> Ekaterinburgo</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            RadioList::widget()->for(new TypeForm(), 'int')->id(null)->items($this->cities)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutName(): void
    {
        $expected = <<<HTML
        <div id="typeform-int">
        <label><input type="radio" name="TypeForm[int]" value="1"> Moscu</label>
        <label><input type="radio" name="TypeForm[int]" value="2"> San Petersburgo</label>
        <label><input type="radio" name="TypeForm[int]" value="3"> Novosibirsk</label>
        <label><input type="radio" name="TypeForm[int]" value="4"> Ekaterinburgo</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            RadioList::widget()->for(new TypeForm(), 'int')->items($this->cities)->name(null)->render(),
        );
    }
}
