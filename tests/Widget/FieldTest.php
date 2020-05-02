<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Tests\Stub\PersonalForm;
use Yiisoft\Form\Widget\Field;

final class FieldTest extends TestCase
{
    public function testFieldsRenderBegin(): void
    {
        $data = new PersonalForm();

        $expected = '<article class="form-group field-personalform-name">';
        $html = Field::widget()
            ->config($data, 'name', ['tag' => 'article'])
            ->renderBegin();
        $this->assertEquals($expected, $html);

        $html = Field::widget()
            ->config($data, 'name', ['tag' => null])
            ->renderBegin();
        $this->assertEquals('', $html);

        $html = Field::widget()
            ->config($data, 'name', ['tag' => false])
            ->renderBegin();
        $this->assertEquals('', $html);
    }

    public function testFieldsRenderEnd(): void
    {
        $data = new PersonalForm();

        $expected = '</div>';
        $html = Field::widget()
            ->renderEnd();
        $this->assertEquals($expected, $html);

        $expected = '';
        $html = Field::widget()
            ->config($data, 'name', ['tag' => null])
            ->renderEnd();
        $this->assertEquals($expected, $html);

        $expected = '';
        $html = Field::widget()
            ->config($data, 'name', ['tag' => false])
            ->renderEnd();
        $this->assertEquals($expected, $html);
    }

    public function testFieldsLabel(): void
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
            ->run();
        $this->assertEquals($expected, $html);

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
        $this->assertEquals($expected, $html);

        $expected = <<<'HTML'
<div class="form-group field-personalform-email">
<label class="control-label" for="personalform-email">Email</label>
<input type="text" id="personalform-email" class="form-control" name="PersonalForm[email]" placeholder="Email">

<div class="help-block"></div>
</div>
HTML;
        $html = Field::widget()
            ->config($data, 'email')
            ->label(true)
            ->run();
        $this->assertEquals($expected, $html);

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
        $this->assertEquals($expected, $html);
    }

    public function testFieldsError(): void
    {
        $data = new PersonalForm();
        $data->name('yii');
        $data->validate();

        $expected = <<<'HTML'
<div class="form-group field-personalform-name">
<label class="control-label" for="personalform-name">Name</label>
<input type="text" id="personalform-name" class="form-control has-error" name="PersonalForm[name]" value="yii" aria-required="true" aria-invalid="true" placeholder="Name">
<div class="hint-block">Write your first name.</div>
<div class="help-block">Is too short.</div>
</div>
HTML;
        $html = Field::widget()
            ->config($data, 'name')
            ->label(true)
            ->run();
        $this->assertEquals($expected, $html);

        $data = new PersonalForm();
        $data->name('yii');
        $data->validate();

        $expected = <<<'HTML'
<div class="form-group field-personalform-name">
<label class="control-label" for="personalform-name">Name</label>
<input type="text" id="personalform-name" class="form-control has-error" name="PersonalForm[name]" value="yii" aria-required="true" aria-invalid="true" placeholder="Name">
<div class="hint-block">Write your first name.</div>
<div class="help-block errorTestMe">Is too short.</div>
</div>
HTML;
        $html = Field::widget()
            ->config($data, 'name')
            ->label(true)
            ->error(['class' => 'errorTestMe'])
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testFieldsTabularInputErrors(): void
    {
        $data = new PersonalForm();
        $data->name('yii');
        $data->validate();

        $expected = <<<'HTML'
<div class="form-group field-personalform-0-name">
<label class="control-label" for="personalform-0-name">Name</label>
<input type="text" id="personalform-0-name" class="form-control has-error" name="PersonalForm[0][name]" value="yii" placeholder="Name">

<div class="help-block"></div>
</div>
HTML;
        $html = Field::widget()
            ->config($data, '[0]name')
            ->label(true)
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testFieldsHint(): void
    {
        $data = new PersonalForm();
        $data->name('Jack Ryan');

        $expected = <<<'HTML'
<div class="form-group field-personalform-name">

<input type="text" id="personalform-name" class="form-control" name="PersonalForm[name]" value="Jack Ryan" aria-required="true" placeholder="Name">

<div class="help-block"></div>
</div>
HTML;
        $html = Field::widget()
            ->config($data, 'name')
            ->hint(null, false)
            ->run();
        $this->assertEquals($expected, $html);

        $expected = <<<'HTML'
<div class="form-group field-personalform-name">

<input type="text" id="personalform-name" class="form-control" name="PersonalForm[name]" value="Jack Ryan" aria-required="true" placeholder="Name">
<div class="hint-block hintTestMe">Write your first name.</div>
<div class="help-block"></div>
</div>
HTML;
        $html = Field::widget()
            ->config($data, 'name')
            ->hint(null, true, ['class' => 'hintTestMe'])
            ->run();
        $this->assertEquals($expected, $html);

        $expected = <<<'HTML'
<div class="form-group field-personalform-name">

<input type="text" id="personalform-name" class="form-control" name="PersonalForm[name]" value="Jack Ryan" aria-required="true" placeholder="Name">
<div class="hint-block">Hint Content</div>
<div class="help-block"></div>
</div>
HTML;
        $html = Field::widget()
            ->config($data, 'name')
            ->hint('Hint Content', true, ['class' => 'hint-block'])
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testFieldsInput(): void
    {
        $data = new PersonalForm();
        $data->email('admin@example.com');

        $expected = <<<'HTML'
<div class="form-group field-personalform-email">

<input type="email" id="personalform-email" class="form-control" name="PersonalForm[email]" value="admin@example.com" placeholder="Email">

<div class="help-block"></div>
</div>
HTML;
        $html = Field::widget()
            ->config($data, 'email')
            ->input('email')
            ->run();
        $this->assertEquals($expected, $html);

        $expected = <<<'HTML'
<div class="form-group field-personalform-email">

<input type="email" id="personalform-email" class="form-control inputTestMe" name="PersonalForm[email]" value="admin@example.com" placeholder="Email">

<div class="help-block"></div>
</div>
HTML;
        $html = Field::widget()
            ->config($data, 'email')
            ->input('email', ['class' => 'inputTestMe'])
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testFieldsTextInput(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<div class="form-group field-personalform-name">

<input type="text" id="personalform-name" class="form-control" name="PersonalForm[name]" aria-required="true" placeholder="Name">
<div class="hint-block">Write your first name.</div>
<div class="help-block"></div>
</div>
HTML;
        $html = Field::widget()
            ->config($data, 'name')
            ->textInput()
            ->run();
        $this->assertEquals($expected, $html);

        $expected = <<<'HTML'
<div class="form-group field-personalform-name">

<input type="text" id="personalform-name" class="form-control textInputTestMe" name="PersonalForm[name]" aria-required="true" placeholder="Name">
<div class="hint-block">Write your first name.</div>
<div class="help-block"></div>
</div>
HTML;
        $html = Field::widget()
            ->config($data, 'name')
            ->textInput(['class' => 'textInputTestMe'])
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testFieldsHiddenInput(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<div class="form-group field-personalform-name">

<input type="hidden" id="personalform-name" class="form-control" name="PersonalForm[name]">
<div class="hint-block">Write your first name.</div>
<div class="help-block"></div>
</div>
HTML;
        $html = Field::widget()
            ->config($data, 'name')
            ->hiddenInput()
            ->run();
        $this->assertEquals($expected, $html);

        $data = new PersonalForm();

        $expected = <<<'HTML'
<div class="form-group field-personalform-name">

<input type="hidden" id="personalform-name" class="form-control hiddenInputTestMe" name="PersonalForm[name]">
<div class="hint-block">Write your first name.</div>
<div class="help-block"></div>
</div>
HTML;
        $html = Field::widget()
            ->config($data, 'name')
            ->hiddenInput(['class' => 'hiddenInputTestMe'])
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testFieldsPasswordInput(): void
    {
        $data = new PersonalForm();

        $data->password('a7gh56ry');
        $data->validate();
        $expected = <<<'HTML'
<div class="form-group field-personalform-password">

<input type="password" id="personalform-password" class="form-control has-error" name="PersonalForm[password]" value="a7gh56ry" aria-required="true" aria-invalid="true" placeholder="Password">

<div class="help-block">Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters.</div>
</div>
HTML;
        $html = Field::widget()
            ->config($data, 'password')
            ->passwordInput()
            ->run();
        $this->assertEquals($expected, $html);

        $expected = <<<'HTML'
<div class="form-group field-personalform-password">

<input type="password" id="personalform-password" class="form-control passwordTestMe has-error" name="PersonalForm[password]" value="a7gh56ry" aria-required="true" aria-invalid="true" placeholder="Password">

<div class="help-block">Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters.</div>
</div>
HTML;
        $html = Field::widget()
            ->config($data, 'password')
            ->passwordInput(['class' => 'passwordTestMe'])
            ->run();
        $this->assertEquals($expected, $html);
    }

    /**
     * @see https://github.com/yiisoft/yii2/issues/8779
     */
    public function testFieldsFileInput(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<div class="form-group field-personalform-attachfiles">
<label class="control-label" for="personalform-attachfiles">Attach Files</label>
<input type="hidden" name="PersonalForm[attachFiles]" value=""><input type="file" id="personalform-attachfiles" class="form-control" name="PersonalForm[attachFiles]" enctype="multipart/form-data">

<div class="help-block"></div>
</div>
HTML;
        $html = Field::widget()
            ->config($data, 'attachFiles')
            ->label(true)
            ->fileInput()
            ->run();
        $this->assertEquals($expected, $html);

        $expected = <<<'HTML'
<div class="form-group field-personalform-attachfiles">
<label class="control-label" for="personalform-attachfiles">Attach Files</label>
<input type="hidden" name="PersonalForm[attachFiles]" value=""><input type="file" id="personalform-attachfiles" class="form-control fileInputTestMe" name="PersonalForm[attachFiles]" enctype="multipart/form-data">

<div class="help-block"></div>
</div>
HTML;
        $html = Field::widget()
            ->config($data, 'attachFiles')
            ->label(true)
            ->fileInput(['class' => 'fileInputTestMe'])
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testFieldsTextArea(): void
    {
        $data = new PersonalForm();

        $data->address('San Petesburgo, Rusia');
        $expected = <<<'HTML'
<div class="form-group field-personalform-name">
<label class="control-label" for="personalform-name">Name</label>
<textarea id="personalform-name" class="form-control" name="PersonalForm[name]" aria-required="true"></textarea>
<div class="hint-block">Write your first name.</div>
<div class="help-block"></div>
</div>
HTML;
        $html = Field::widget()
            ->config($data, 'name')
            ->label(true)
            ->textArea()
            ->run();
        $this->assertEquals($expected, $html);

        $expected = <<<'HTML'
<div class="form-group field-personalform-name">
<label class="control-label" for="personalform-name">Name</label>
<textarea id="personalform-name" class="form-control textAreaTestMe" name="PersonalForm[name]" aria-required="true"></textarea>
<div class="hint-block">Write your first name.</div>
<div class="help-block"></div>
</div>
HTML;
        $html = Field::widget()
            ->config($data, 'name')
            ->label(true)
            ->textArea(['class' => 'textAreaTestMe'])
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testFieldsRadioList(): void
    {
        $data = new PersonalForm();
        $data->terms(true);

        $expected = <<<'HTML'
<div class="form-group field-personalform-terms">
<label class="control-label" for="personalform-terms">Terms</label>
<input type="hidden" name="PersonalForm[terms]" value=""><div id="personalform-terms" class="form-control" role="radiogroup"><label><input type="radio" name="PersonalForm[terms]" value="1" checked> Accept terms and conditions.</label></div>

<div class="help-block"></div>
</div>
HTML;
        $html = Field::widget()
            ->config($data, 'terms')
            ->label(true)
            ->radioList(['1' => 'Accept terms and conditions.'], ['unselect' => ''])
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testFieldsAriaAttributes(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<div class="form-group field-personalform-name">
<label class="control-label" for="personalform-name">Name</label>
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
        $this->assertEquals($expected, $html);

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
            ->label(true)
            ->run();
        $this->assertEquals($expected, $html);

        $data->name('yii');
        $data->validate();
        $expected = <<<'HTML'
<div class="form-group field-personalform-name">
<label class="control-label" for="personalform-name">Name</label>
<input type="text" id="personalform-name" class="form-control has-error" name="PersonalForm[name]" value="yii" aria-required="true" aria-invalid="true" placeholder="Name">
<div class="hint-block">Write your first name.</div>
<div class="help-block">Is too short.</div>
</div>
HTML;
        $html = Field::widget()
            ->config($data, 'name')
            ->label(true)
            ->run();
        $this->assertEquals($expected, $html);
    }
}
