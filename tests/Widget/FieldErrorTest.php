<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Tests\Stub\PersonalForm;
use Yiisoft\Form\Widget\Field;

final class FieldErrorTest extends TestCase
{
    public function testFieldError(): void
    {
        $data = new PersonalForm();
        $data->name('yii');
        $data->validate();

        $expected = <<<'HTML'
<div class="form-group field-personalform-name">
<label class="control-label" for="personalform-name">Name</label>
<input type="text" id="personalform-name" class="form-control has-error" name="PersonalForm[name]" value="yii" aria-required="true" aria-invalid="true" placeholder="Name">
<div class="hint-block">Write your first name.</div>
<div class="help-block">Is too short.</div>
</div>
HTML;
        $html = Field::widget()
            ->config($data, 'name')
            ->label(true)
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testFieldErrorOptions(): void
    {
        $data = new PersonalForm();
        $data->name('yii');
        $data->validate();

        $expected = <<<'HTML'
<div class="form-group field-personalform-name">
<label class="control-label" for="personalform-name">Name</label>
<input type="text" id="personalform-name" class="form-control has-error" name="PersonalForm[name]" value="yii" aria-required="true" aria-invalid="true" placeholder="Name">
<div class="hint-block">Write your first name.</div>
<div class="help-block errorTestMe">Is too short.</div>
</div>
HTML;
        $html = Field::widget()
            ->config($data, 'name')
            ->label(true)
            ->error(['class' => 'errorTestMe'])
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testFieldsTabularInputErrors(): void
    {
        $data = new PersonalForm();
        $data->name('yii');
        $data->validate();

        $expected = <<<'HTML'
<div class="form-group field-personalform-0-name">
<label class="control-label" for="personalform-0-name">Name</label>
<input type="text" id="personalform-0-name" class="form-control has-error" name="PersonalForm[0][name]" value="yii" placeholder="Name">

<div class="help-block">Is too short.</div>
</div>
HTML;
        $html = Field::widget()
            ->config($data, '[0]name')
            ->label(true)
            ->run();
        $this->assertEquals($expected, $html);
    }
}
