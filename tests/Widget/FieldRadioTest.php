<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Tests\Stub\PersonalForm;
use Yiisoft\Form\Widget\Field;

final class FieldRadioTest extends TestCase
{
    public function testFieldRadioClosedByLabel(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<div class="form-group field-personalform-terms">

<input type="hidden" name="PersonalForm[terms]" value="0"><label><input type="radio" id="personalform-terms" name="PersonalForm[terms]" value="1"> Terms</label>

<div class="help-block"></div>
</div>
HTML;
        $html = Field::widget()
            ->config($data, 'terms')
            ->radio()
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testFieldRadioUnclosedByLabel(): void
    {
        $data = new PersonalForm();
        $data->terms(true);

        $expected = <<<'HTML'
<div class="form-group field-personalform-terms">
<label class="control-label" for="personalform-terms">Terms</label>
<input type="hidden" name="PersonalForm[terms]" value="0"><input type="radio" id="personalform-terms" name="PersonalForm[terms]" value="1" checked>

<div class="help-block"></div>
</div>
HTML;
        $html = Field::widget()
            ->config($data, 'terms')
            ->radio([], false)
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testFieldRadioLabelWithLabelOptions(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<div class="form-group field-personalform-terms">
<label class="control-label customCssLabel" for="personalform-terms">customLabel</label>
<input type="hidden" name="PersonalForm[terms]" value="0"><input type="radio" id="personalform-terms" name="PersonalForm[terms]" value="1">

<div class="help-block"></div>
</div>
HTML;
        $html = Field::widget()
            ->config($data, 'terms')
            ->radio(['label' => 'customLabel', 'labelOptions' => ['class' => 'customCssLabel']], false)
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testFieldRadioWithoutAnyLabel(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<div class="form-group field-personalform-terms">

<input type="hidden" name="PersonalForm[terms]" value="0"><input type="radio" id="personalform-terms" name="PersonalForm[terms]" value="1">

<div class="help-block"></div>
</div>
HTML;
        $html = Field::widget()
            ->config($data, 'terms')
            ->radio(['label' => false], false)
            ->run();
        $this->assertEquals($expected, $html);
    }
}
