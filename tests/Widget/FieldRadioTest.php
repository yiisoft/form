<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Form\Tests\Widget;

use Yiisoft\Yii\Form\Tests\TestCase;
use Yiisoft\Yii\Form\Tests\Stub\PersonalForm;
use Yiisoft\Yii\Form\Widget\Field;

final class FieldRadioTest extends TestCase
{
    public function testFieldRadio(): void
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
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testFieldRadioUnClosedByLabel(): void
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
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testFieldRadioWithLabelCustomUnClosedByLabel(): void
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
            ->label(true, ['class' => 'customCssLabel'], 'customLabel')
            ->radio([], false)
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testFieldRadioAnyLabel(): void
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
            ->label(false)
            ->radio([], false)
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }
}
