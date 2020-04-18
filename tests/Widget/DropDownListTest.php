<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Tests\Stub\StubForm;
use Yiisoft\Form\Widget\DropDownList;

final class DropDownListTest extends TestCase
{
    public function testDropDownList(): void
    {
        $expected = <<<'HTML'
<input type="hidden" name="StubForm[fieldArray]" value=""><select id="stubform-fieldarray" name="StubForm[fieldArray][]" multiple="true" size="4">
<option value="city1">1</option>
<option value="city2">2</option>
</select>
HTML;
        $form = new StubForm();
        $created = DropDownList::widget()
            ->form($form)
            ->attribute('fieldArray')
            ->multiple(true)
            ->items(['city1' => 1, 'city2' => 2])
            ->run();
        $this->assertEqualsWithoutLE($expected, $created);
    }
}
