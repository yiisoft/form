<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Form\Tests\Widget;

use Yiisoft\Yii\Form\Tests\TestCase;
use Yiisoft\Yii\Form\Tests\Stub\PersonalForm;
use Yiisoft\Yii\Form\Widget\Field;

final class FieldHintTest extends TestCase
{
    public function testFieldsHint(): void
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

    public function testFieldHintCustom(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<div class="form-group field-personalform-name">
<label class="control-label" for="personalform-name">Name</label>
<input type="text" id="personalform-name" class="form-control" name="PersonalForm[name]" aria-required="true" placeholder="Name">
<div class="hint-block customClass">Custom hint.</div>
<div class="help-block"></div>
</div>
HTML;
        $html = Field::widget()
            ->config($data, 'name')
            ->hint('Custom hint.', true, ['class' => 'customClass'])
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testFieldAnyHint(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<div class="form-group field-personalform-name">
<label class="control-label" for="personalform-name">Name</label>
<input type="text" id="personalform-name" class="form-control" name="PersonalForm[name]" aria-required="true" placeholder="Name">

<div class="help-block"></div>
</div>
HTML;
        $html = Field::widget()
            ->config($data, 'name')
            ->hint(null, false)
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }
}
