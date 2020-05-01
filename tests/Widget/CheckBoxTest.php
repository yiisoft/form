<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Tests\Stub\PersonalForm;
use Yiisoft\Form\Widget\CheckBox;

final class CheckBoxTest extends TestCase
{
    public function testCheckBox(): void
    {
        $data = new PersonalForm();

        $data->terms(true);
        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[terms]" value="0"><label><input type="checkbox" id="personalform-terms" name="PersonalForm[terms]" value="1" checked> Terms</label>
HTML;
        $html = CheckBox::widget()
            ->config($data, 'terms')
            ->uncheck(true)
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testCheckBoxOptions(): void
    {
        $data = new PersonalForm();
        $data->terms(true);

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[terms]" value="0"><label><input type="checkbox" id="personalform-terms" class="customClass" name="PersonalForm[terms]" value="1" checked> Terms</label>
HTML;
        $html = CheckBox::widget()
            ->config($data, 'terms', ['class' => 'customClass'])
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testCheckBoxNoLabel(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[terms]" value="0"><input type="checkbox" id="personalform-terms" name="PersonalForm[terms]" value="1">
HTML;
        $html = CheckBox::widget()
            ->config($data, 'terms')
            ->noLabel()
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testCheckBoxUncheck(): void
    {
        $data = new PersonalForm();
        $data->terms(true);

        $expected = <<<'HTML'
<label><input type="checkbox" id="personalform-terms" name="PersonalForm[terms]" value="1" checked> Terms</label>
HTML;
        $html = CheckBox::widget()
            ->config($data, 'terms')
            ->uncheck(false)
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testCheckBoxLabelWithLabelOptions(): void
    {
        $data = new PersonalForm();
        $data->terms(true);

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[terms]" value="0"><label class="labelClass"><input type="checkbox" id="personalform-terms" name="PersonalForm[terms]" value="1" checked> customLabel</label>
HTML;
        $html = CheckBox::widget()
            ->config($data, 'terms')
            ->label('customLabel')
            ->labelOptions(['class' => 'labelClass'])
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testCheckBoxAutofocus(): void
    {
        $data = new PersonalForm();
        $data->terms(true);

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[terms]" value="0"><label><input type="checkbox" id="personalform-terms" name="PersonalForm[terms]" value="1" checked autofocus> Terms</label>
HTML;
        $html = CheckBox::widget()
            ->config($data, 'terms')
            ->autofocus()
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testCheckBoxDisabled(): void
    {
        $data = new PersonalForm();
        $data->terms(true);

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[terms]" value="0" disabled><label><input type="checkbox" id="personalform-terms" name="PersonalForm[terms]" value="1" checked disabled> Terms</label>
HTML;
        $html = CheckBox::widget()
            ->config($data, 'terms')
            ->disabled()
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testCheckBoxForm(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[terms]" value="0" form="form-id"><label><input type="checkbox" id="personalform-terms" name="PersonalForm[terms]" value="1" form="form-id"> Terms</label>
HTML;
        $html = CheckBox::widget()
            ->config($data, 'terms')
            ->form('form-id')
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testCheckBoxId(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[terms]" value="0"><label><input type="checkbox" id="custom-id" name="PersonalForm[terms]" value="1"> Terms</label>
HTML;
        $html = CheckBox::widget()
            ->id('custom-id')
            ->config($data, 'terms')
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testCheckBoxRequired(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[terms]" value="0"><label><input type="checkbox" id="personalform-terms" name="PersonalForm[terms]" value="1" required> Terms</label>
HTML;
        $html = CheckBox::widget()
            ->config($data, 'terms')
            ->required(true)
            ->run();
        $this->assertEquals($expected, $html);
    }
}
