<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use Yiisoft\Form\Tests\Stub\PersonalForm;
use Yiisoft\Form\Tests\Stub\ValidatorMock;
use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Widget\Field;
use Yiisoft\Validator\ValidatorInterface;

final class FieldTest extends TestCase
{
    public function testFieldAriaAttributes(): void
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
            ->ariaAttribute(false)
            ->label(true)
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);

        $expected = <<<'HTML'
<div class="form-group field-personalform-name">
<label class="control-label required" for="personalform-name">Name</label>
<input type="text" id="personalform-name" class="form-control" name="PersonalForm[name]" aria-required="true" placeholder="Name">
<div class="hint-block">Write your first name.</div>
<div class="help-block"></div>
</div>
HTML;
        $html = Field::widget()
            ->config($data, 'name')
            ->label(true)
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);

        $data->name('yii');
        $data->validate($this->createValidatorMock());
        $expected = <<<'HTML'
<div class="form-group field-personalform-name">
<label class="control-label required" for="personalform-name">Name</label>
<input type="text" id="personalform-name" class="form-control has-error" name="PersonalForm[name]" value="yii" aria-required="true" aria-invalid="true" placeholder="Name">
<div class="hint-block">Write your first name.</div>
<div class="help-block">Is too short.</div>
</div>
HTML;
        $html = Field::widget()
            ->config($data, 'name')
            ->label(true)
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testEnclosedByContainer(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<label class="control-label required" for="personalform-name">Name</label>
<input type="text" id="personalform-name" class="form-control" name="PersonalForm[name]" aria-required="true" placeholder="Name">
<div class="hint-block">Write your first name.</div>
<div class="help-block"></div>
HTML;
        $html = Field::widget()
            ->config($data, 'name')
            ->enclosedByContainer(false)
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    private function createValidatorMock(): ValidatorInterface
    {
        return new ValidatorMock();
    }
}
