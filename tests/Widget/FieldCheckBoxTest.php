<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use Yiisoft\Form\Tests\Stub\PersonalForm;
use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Widget\Field;

final class FieldCheckBoxTest extends TestCase
{
    public function testFieldCheckBox(): void
    {
        $data = new PersonalForm();
        $data->terms(true);

        $expected = <<<'HTML'
<div class="form-group field-personalform-terms">

<input type="hidden" name="PersonalForm[terms]" value="0"><label><input type="checkbox" id="personalform-terms" name="PersonalForm[terms]" value="1" checked> Terms</label>

<div class="help-block"></div>
</div>
HTML;
        $html = Field::widget()
            ->config($data, 'terms')
            ->checkbox()
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testFieldCheckBoxUnclosedByLabel(): void
    {
        $data = new PersonalForm();
        $data->terms(true);

        $expected = <<<'HTML'
<div class="form-group field-personalform-terms">
<label class="control-label" for="personalform-terms">Terms</label>
<input type="hidden" name="PersonalForm[terms]" value="0"><input type="checkbox" id="personalform-terms" name="PersonalForm[terms]" value="1" checked>

<div class="help-block"></div>
</div>
HTML;
        $html = Field::widget()
            ->config($data, 'terms')
            ->checkbox([], false)
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testFieldCheckBoxWithLabelCustomUnClosedByLabel(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<div class="form-group field-personalform-terms">
<label class="control-label customCssLabel" for="personalform-terms">customLabel</label>
<input type="hidden" name="PersonalForm[terms]" value="0"><input type="checkbox" id="personalform-terms" name="PersonalForm[terms]" value="1">

<div class="help-block"></div>
</div>
HTML;
        $html = Field::widget()
            ->config($data, 'terms')
            ->label(true, ['class' => 'customCssLabel'], 'customLabel')
            ->checkbox([], false)
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testFieldCheckBoxAnyLabel(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<div class="form-group field-personalform-terms">

<input type="hidden" name="PersonalForm[terms]" value="0"><input type="checkbox" id="personalform-terms" name="PersonalForm[terms]" value="1">

<div class="help-block"></div>
</div>
HTML;
        $html = Field::widget()
            ->config($data, 'terms')
            ->label(false)
            ->checkbox([], false)
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }
}
