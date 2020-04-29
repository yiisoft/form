<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Tests\Stub\StubForm;
use Yiisoft\Form\Widget\ListBox;

final class ListBoxTest extends TestCase
{
    public function testListBox(): void
    {
        $form = new StubForm();

        $expected = <<<'EOD'
<select id="stubform-fieldarray" name="StubForm[fieldArray]" size="4" required>

</select>
EOD;
        $created = ListBox::widget()
            ->config($form, 'fieldArray')
            ->required()
            ->run();
        $this->assertEqualsWithoutLE($expected, $created);

        $expected = <<<'EOD'
<select id="stubform-fieldarray" name="StubForm[fieldArray]" size="5">
<option value="value1">text1</option>
<option value="value2">text2</option>
</select>
EOD;
        $created = ListBox::widget()
            ->config($form, 'fieldArray')
            ->items($this->getDataItems())
            ->required(false)
            ->addSize(5)
            ->run();
        $this->assertEqualsWithoutLE($expected, $created);

        $expected = <<<'EOD'
<select id="stubform-fieldarray" name="StubForm[fieldArray]" size="4" required>
<option value="value1&lt;&gt;">text1&lt;&gt;</option>
<option value="value  2">text  2</option>
</select>
EOD;
        $created = ListBox::widget()
            ->config($form, 'fieldArray')
            ->items($this->getDataItems2())
            ->required()
            ->run();
        $this->assertEqualsWithoutLE($expected, $created);

        $expected = <<<'EOD'
<select id="stubform-fieldarray" name="StubForm[fieldArray]" size="4">
<option value="value1&lt;&gt;">text1&lt;&gt;</option>
<option value="value  2">text&nbsp;&nbsp;2</option>
</select>
EOD;
        $created = ListBox::widget()
            ->config($form, 'fieldArray', ['encodeSpaces' => true, 'required' => false])
            ->items($this->getDataItems2())
            ->run();
        $this->assertEqualsWithoutLE($expected, $created);

        $expected = <<<'EOD'
<select id="stubform-fieldarray" name="StubForm[fieldArray]" size="4">
<option value="value1&lt;&gt;">text1<></option>
<option value="value  2">text  2</option>
</select>
EOD;
        $created = ListBox::widget()
            ->config($form, 'fieldArray', ['encode' => false, 'required' => false])
            ->items($this->getDataItems2())
            ->run();
        $this->assertEqualsWithoutLE($expected, $created);

        $expected = <<<'EOD'
<select id="stubform-fieldarray" name="StubForm[fieldArray]" size="4" required>
<option value="value1&lt;&gt;">text1<></option>
<option value="value  2">text&nbsp;&nbsp;2</option>
</select>
EOD;
        $created = ListBox::widget()
            ->config($form, 'fieldArray', ['encodeSpaces' => true, 'encode' => false])
            ->items($this->getDataItems2())
            ->required()
            ->run();
        $this->assertEqualsWithoutLE($expected, $created);

        $form->fieldArray(['value2']);
        $expected = <<<'EOD'
<select id="stubform-fieldarray" name="StubForm[fieldArray]" size="4">
<option value="value1">text1</option>
<option value="value2" selected>text2</option>
</select>
EOD;
        $created = ListBox::widget()
            ->config($form, 'fieldArray', ['required' => false])
            ->items($this->getDataItems())
            ->run();
        $this->assertEqualsWithoutLE($expected, $created);

        $expected = <<<'EOD'
<select id="stubform-fieldarray" name="StubForm[fieldArray]" size="4" required>
<option value="value1" selected>text1</option>
<option value="value2" selected>text2</option>
</select>
EOD;
        $form->fieldArray(['value1', 'value2']);
        $created = ListBox::widget()
            ->config($form, 'fieldArray')
            ->items($this->getDataItems())
            ->required()
            ->run();
        $this->assertEqualsWithoutLE($expected, $created);

        $expected = <<<'EOD'
<select id="stubform-fieldarray" name="StubForm[fieldArray][]" multiple size="4">

</select>
EOD;
        $created = ListBox::widget()
            ->config($form, 'fieldArray', ['multiple' => true, 'required' => false])
            ->run();
        $this->assertEqualsWithoutLE($expected, $created);

        $expected = <<<'EOD'
<input type="hidden" name="StubForm[fieldArray]" value="0"><select id="stubform-fieldarray" name="StubForm[fieldArray]" size="4">

</select>
EOD;
        $created = ListBox::widget()
            ->config($form, 'fieldArray', ['required' => false, 'unselect' => '0'])
            ->run();
        $this->assertEqualsWithoutLE($expected, $created);

        $expected = <<<'EOD'
<input type="hidden" name="StubForm[fieldArray]" value="0" disabled><select id="stubform-fieldarray" name="StubForm[fieldArray]" disabled size="4">

</select>
EOD;
        $created = ListBox::widget()
            ->config($form, 'fieldArray', ['disabled' => true, 'required' => false])
            ->unselect('0')
            ->run();
        $this->assertEqualsWithoutLE($expected, $created);

        $expected = <<<'EOD'
<select id="stubform-fieldarray" name="StubForm[fieldArray]" size="4" required>
<option value="value1" selected>text1</option>
<option value="value2" selected>text2</option>
</select>
EOD;
        $form->fieldArray(new \ArrayObject(['value1', 'value2']));
        $created = ListBox::widget()
            ->config($form, 'fieldArray')
            ->items($this->getDataItems())
            ->required()
            ->run();
        $this->assertEqualsWithoutLE($expected, $created);

        $expected = <<<'EOD'
<select id="stubform-fieldarray" name="StubForm[fieldArray]" size="4" required>
<option value="0" selected>zero</option>
<option value="1">one</option>
<option value="value3">text3</option>
</select>
EOD;
        $form->fieldArray(['0']);
        $created = ListBox::widget()
            ->config($form, 'fieldArray')
            ->items($this->getDataItems3())
            ->required()
            ->run();
        $this->assertEqualsWithoutLE($expected, $created);

        $form->fieldArray(new \ArrayObject([0]));
        $created = ListBox::widget()
            ->config($form, 'fieldArray')
            ->items($this->getDataItems3())
            ->required()
            ->run();
        $this->assertEqualsWithoutLE($expected, $created);

        $expected = <<<'EOD'
<select id="stubform-fieldarray" name="StubForm[fieldArray]" size="4">
<option value="0">zero</option>
<option value="1" selected>one</option>
<option value="value3" selected>text3</option>
</select>
EOD;
        $form->fieldArray(['1', 'value3']);
        $created = ListBox::widget()
            ->config($form, 'fieldArray')
            ->items($this->getDataItems3())
            ->run();
        $this->assertEqualsWithoutLE($expected, $created);

        $form->fieldArray(new \ArrayObject(['1', 'value3']));
        $created = ListBox::widget()
            ->config($form, 'fieldArray')
            ->items($this->getDataItems3())
            ->run();
        $this->assertEqualsWithoutLE($expected, $created);
    }

    private function getDataItems(): array
    {
        return [
            'value1' => 'text1',
            'value2' => 'text2',
        ];
    }

    private function getDataItems2(): array
    {
        return [
            'value1<>' => 'text1<>',
            'value  2' => 'text  2',
        ];
    }

    protected function getDataItems3(): array
    {
        return [
            'zero',
            'one',
            'value3' => 'text3',
        ];
    }
}
