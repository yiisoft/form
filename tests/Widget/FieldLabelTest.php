<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Form\Tests\Widget;

use Yiisoft\Yii\Form\Tests\TestCase;
use Yiisoft\Yii\Form\Tests\Stub\PersonalForm;
use Yiisoft\Yii\Form\Widget\Field;

final class FieldLabelTest extends TestCase
{
    public function testFieldLabel(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<div class="form-group field-personalform-email">
<label class="control-label" for="personalform-email">Email</label>
<input type="text" id="personalform-email" class="form-control" name="PersonalForm[email]" placeholder="Email">

<div class="help-block"></div>
</div>
HTML;
        $html = Field::widget()
            ->config($data, 'email')
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testFieldLabelCustom(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<div class="form-group field-personalform-email">
<label class="control-label labelTestMe" for="personalform-email">Email:</label>
<input type="text" id="personalform-email" class="form-control" name="PersonalForm[email]" placeholder="Email">

<div class="help-block"></div>
</div>
HTML;
        $html = Field::widget()
            ->config($data, 'email')
            ->label(true, ['class' => 'labelTestMe'], 'Email:')
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testFieldAnyLabel(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<div class="form-group field-personalform-email">

<input type="text" id="personalform-email" class="form-control" name="PersonalForm[email]" placeholder="Email">

<div class="help-block"></div>
</div>
HTML;
        $html = Field::widget()
            ->config($data, 'email')
            ->label(false)
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }
}
