<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Form\Tests\Widget;

use Yiisoft\Yii\Form\Tests\TestCase;
use Yiisoft\Yii\Form\Tests\Stub\PersonalForm;
use Yiisoft\Yii\Form\Widget\Field;

final class FieldTextAreaTest extends TestCase
{
    public function testFieldsTextArea(): void
    {
        $data = new PersonalForm();
        $data->address('San Petesburgo, Rusia');

        $expected = <<<'HTML'
<div class="form-group field-personalform-address">
<label class="control-label" for="personalform-address">Address</label>
<textarea id="personalform-address" class="form-control" name="PersonalForm[address]" placeholder="Address">San Petesburgo, Rusia</textarea>

<div class="help-block"></div>
</div>
HTML;
        $html = Field::widget()
            ->config($data, 'address')
            ->textArea()
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testFieldsTextAreaWithLabelCustom(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<div class="form-group field-personalform-address">
<label class="control-label customClass" for="personalform-address">Address:</label>
<textarea id="personalform-address" class="form-control" name="PersonalForm[address]" placeholder="Address"></textarea>

<div class="help-block"></div>
</div>
HTML;
        $html = Field::widget()
            ->config($data, 'address')
            ->label(true, ['class' => 'customClass'], 'Address:')
            ->textArea()
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testFieldsTextAreaAnyLabel(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<div class="form-group field-personalform-address">

<textarea id="personalform-address" class="form-control" name="PersonalForm[address]" placeholder="Address"></textarea>

<div class="help-block"></div>
</div>
HTML;
        $html = Field::widget()
            ->config($data, 'address')
            ->label(false)
            ->textArea()
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }
}
