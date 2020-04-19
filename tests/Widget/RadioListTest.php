<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Tests\Stub\StubForm;
use Yiisoft\Form\Widget\RadioList;

final class RadioListTest extends TestCase
{
    public function testActiveRadioList()
    {
        $form = new StubForm();

        $expected = <<<'HTML'
<input type="hidden" name="StubForm[fieldArray]" value=""><div id="stubform-fieldarray" class="testMe"><label><input type="radio" name="StubForm[fieldArray]" value="0"> foo</label></div>
HTML;
        $created = RadioList::widget()
            ->form($form)
            ->attribute('fieldArray')
            ->items(['foo'])
            ->options(['class' => 'testMe'])
            ->run();
        $this->assertEqualsWithoutLE($expected, $created);
    }
}
