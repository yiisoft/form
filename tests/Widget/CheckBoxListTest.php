<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Tests\Stub\StubForm;
use Yiisoft\Form\Widget\CheckBoxList;

final class CheckBoxListTest extends TestCase
{
    public function testCheckboxList(): void
    {
        $form = new StubForm();

        $expected = <<<'HTML'
<input type="hidden" name="StubForm[fieldArray]" value=""><div id="stubform-fieldarray"><label><input type="checkbox" name="StubForm[fieldArray][]" value="0"> foo</label>
<label><input type="checkbox" name="StubForm[fieldArray][]" value="1"> bar</label></div>
HTML;
        $created = CheckboxList::widget()
            ->data($form)
            ->attribute('fieldArray')
            ->items(['foo', 'bar'])
            ->run();
        $this->assertEqualsWithoutLE($expected, $created);
    }

    public function testCheckboxListOptions(): void
    {
        $form = new StubForm();
        $expected = <<<'HTML'
<input type="hidden" name="foo" value=""><div id="stubform-fieldarray"><label><input type="checkbox" name="foo[]" value="0" checked> foo</label></div>
HTML;
        $created = CheckboxList::widget()
            ->data($form)
            ->attribute('fieldArray')
            ->items(['foo'])
            ->options(['name' => 'foo', 'value' => 0])
            ->run();
        $this->assertEqualsWithoutLE($expected, $created);
    }
}
