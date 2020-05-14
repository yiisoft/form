<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Form\Tests\Widget;

use Yiisoft\Yii\Form\Tests\TestCase;
use Yiisoft\Yii\Form\Tests\Stub\PersonalForm;
use Yiisoft\Yii\Form\Widget\HiddenInput;

final class HiddenInputTest extends TestCase
{
    public function testHiddenInput(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="hidden" id="personalform-name" name="PersonalForm[name]">
HTML;
        $html = HiddenInput::widget()
            ->config($data, 'name')
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testHiddenInputOptions(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="hidden" id="personalform-name" class="customClass" name="PersonalForm[name]" value="1">
HTML;
        $html = HiddenInput::widget()
            ->config($data, 'name', ['value' => '1', 'class' => 'customClass'])
            ->run();
        $this->assertEquals($expected, $html);
    }
}
