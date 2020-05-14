<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Form\Tests\Widget;

use Yiisoft\Yii\Form\Tests\TestCase;
use Yiisoft\Yii\Form\Tests\Stub\PersonalForm;
use Yiisoft\Yii\Form\Widget\Field;

final class FieldTextInputTest extends TestCase
{
    public function testFieldTextInput(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<div class="form-group field-personalform-name">
<label class="control-label" for="personalform-name">Name</label>
<input type="text" id="personalform-name" class="form-control" name="PersonalForm[name]" aria-required="true" placeholder="Name">
<div class="hint-block">Write your first name.</div>
<div class="help-block"></div>
</div>
HTML;
        $html = Field::widget()
            ->config($data, 'name')
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testFieldTextInputWithLabelCustom(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<div class="form-group field-personalform-name">
<label class="control-label customClass" for="personalform-name">Name:</label>
<input type="text" id="personalform-name" class="form-control" name="PersonalForm[name]" aria-required="true" placeholder="Name">
<div class="hint-block">Write your first name.</div>
<div class="help-block"></div>
</div>
HTML;
        $html = Field::widget()
            ->config($data, 'name')
            ->label(true, ['class' => 'customClass'], 'Name:')
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testFieldTextInputAnyLabel(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<div class="form-group field-personalform-name">

<input type="text" id="personalform-name" class="form-control" name="PersonalForm[name]" aria-required="true" placeholder="Name">
<div class="hint-block">Write your first name.</div>
<div class="help-block"></div>
</div>
HTML;
        $html = Field::widget()
            ->config($data, 'name')
            ->label(false)
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }
}
