<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use Yiisoft\Form\Tests\Stub\PersonalForm;
use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Widget\Field;

final class FieldPasswordInputTest extends TestCase
{
    public function testFieldsPasswordInput(): void
    {
        $data = new PersonalForm();

        $data->password('a7gh56ry');
        $data->validate();

        $expected = <<<'HTML'
<div class="form-group field-personalform-password">
<label class="control-label" for="personalform-password">Password</label>
<input type="password" id="personalform-password" class="form-control has-error" name="PersonalForm[password]" value="a7gh56ry" aria-required="true" aria-invalid="true" placeholder="Password">

<div class="help-block">Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters.</div>
</div>
HTML;
        $html = Field::widget()
            ->config($data, 'password')
            ->passwordInput()
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testFieldsPasswordInputWithLabelCustom(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<div class="form-group field-personalform-password">
<label class="control-label customClass" for="personalform-password">Password:</label>
<input type="password" id="personalform-password" class="form-control" name="PersonalForm[password]" aria-required="true" placeholder="Password">

<div class="help-block"></div>
</div>
HTML;
        $html = Field::widget()
            ->config($data, 'password')
            ->label(true, ['class' => 'customClass'], 'Password:')
            ->passwordInput()
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testFieldsPasswordInputAnyLabel(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<div class="form-group field-personalform-password">

<input type="password" id="personalform-password" class="form-control" name="PersonalForm[password]" aria-required="true" placeholder="Password">

<div class="help-block"></div>
</div>
HTML;
        $html = Field::widget()
            ->config($data, 'password')
            ->label(false)
            ->passwordInput()
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }
}
