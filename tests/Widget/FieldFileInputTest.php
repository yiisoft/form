<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use Yiisoft\Form\Tests\Stub\PersonalForm;
use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Widget\Field;

final class FieldFileInputTest extends TestCase
{
    /**
     * @see https://github.com/yiisoft/yii2/issues/8779
     */
    public function testFieldFileInput(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<div class="form-group field-personalform-attachfiles">
<label class="control-label" for="personalform-attachfiles">Attach Files</label>
<input type="hidden" name="PersonalForm[attachFiles]" value=""><input type="file" id="personalform-attachfiles" class="form-control" name="PersonalForm[attachFiles]">

<div class="help-block"></div>
</div>
HTML;
        $html = Field::widget()
            ->config($data, 'attachFiles')
            ->fileInput()
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testFieldFileInputWithLabelCustom(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<div class="form-group field-personalform-attachfiles">
<label class="control-label customClass" for="personalform-attachfiles">Attach Files:</label>
<input type="hidden" name="PersonalForm[attachFiles]" value=""><input type="file" id="personalform-attachfiles" class="form-control" name="PersonalForm[attachFiles]">

<div class="help-block"></div>
</div>
HTML;
        $html = Field::widget()
            ->config($data, 'attachFiles')
            ->label(true, ['class' => 'customClass'], 'Attach Files:')
            ->fileInput()
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testFieldFileInputAnyLabel(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<div class="form-group field-personalform-attachfiles">

<input type="hidden" name="PersonalForm[attachFiles]" value=""><input type="file" id="personalform-attachfiles" class="form-control" name="PersonalForm[attachFiles]">

<div class="help-block"></div>
</div>
HTML;
        $html = Field::widget()
            ->config($data, 'attachFiles')
            ->label(false)
            ->fileInput()
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testFieldFileInputWithoutHiddenInput(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<div class="form-group field-personalform-attachfiles">
<label class="control-label" for="personalform-attachfiles">Attach Files</label>
<input type="file" id="personalform-attachfiles" class="form-control" name="PersonalForm[attachFiles]">

<div class="help-block"></div>
</div>
HTML;
        $html = Field::widget()
            ->config($data, 'attachFiles')
            ->fileInput([], true)
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }
}
