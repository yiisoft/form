<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use Yiisoft\Form\Tests\Stub\PersonalForm;
use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Widget\Field;

final class FieldInputTest extends TestCase
{
    public function testFieldsInput(): void
    {
        $data = new PersonalForm();
        $data->email('admin@example.com');

        $expected = <<<'HTML'
<div class="form-group field-personalform-email">
<label class="control-label" for="personalform-email">Email</label>
<input type="email" id="personalform-email" class="form-control has-success" name="PersonalForm[email]" value="admin@example.com" placeholder="Email">

<div class="help-block"></div>
</div>
HTML;
        $html = Field::widget()
            ->config($data, 'email')
            ->input('email')
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testFieldsInputWithLabelCustom(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<div class="form-group field-personalform-email">
<label class="control-label customClass" for="personalform-email">Email:</label>
<input type="email" id="personalform-email" class="form-control has-success" name="PersonalForm[email]" placeholder="Email">

<div class="help-block"></div>
</div>
HTML;
        $html = Field::widget()
            ->config($data, 'email')
            ->label(true, ['class' => 'customClass'], 'Email:')
            ->input('email')
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testFieldsInputAnyLabel(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<div class="form-group field-personalform-email">

<input type="email" id="personalform-email" class="form-control has-success" name="PersonalForm[email]" placeholder="Email">

<div class="help-block"></div>
</div>
HTML;
        $html = Field::widget()
            ->config($data, 'email')
            ->label(false)
            ->input('email')
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }
}
