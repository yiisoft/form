<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use Yiisoft\Form\Tests\Stub\PersonalForm;
use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Widget\Field;

final class FieldTextInputTest extends TestCase
{
    public function testFieldTextInput(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<div class="form-group field-personalform-name">
<label class="control-label required" for="personalform-name">Name</label>
<input type="text" id="personalform-name" class="form-control" name="PersonalForm[name]" placeholder="Name">
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
<label class="control-label customClass required" for="personalform-name">Name:</label>
<input type="text" id="personalform-name" class="form-control" name="PersonalForm[name]" placeholder="Name">
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

<input type="text" id="personalform-name" class="form-control" name="PersonalForm[name]" placeholder="Name">
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
