<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Html;

use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Tests\Stub\StubForm;
use Yiisoft\Form\Widget\HiddenInput;

final class HiddenInputTest extends TestCase
{
    public function testHiddenInput(): void
    {
        $form = new StubForm();

        $expected = '<input type="hidden" id="stubform-fieldstring" name="test">';
        $created = HiddenInput::widget()
            ->form($form)
            ->attribute('fieldString')
            ->options(['name' => 'test'])
            ->run();
        $this->assertEquals($expected, $created);

        $expected = '<input type="hidden" id="stubform-fieldstring" class="test" name="test" value="value">';
        $created = HiddenInput::widget()
            ->form($form)
            ->attribute('fieldString')
            ->options(['name' => 'test', 'value' => 'value', 'class' => 'test'])
            ->run();
        $this->assertEquals($expected, $created);
    }
}
