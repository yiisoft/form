<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use Yiisoft\Form\Tests\Stub\PersonalForm;
use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Widget\BooleanInput;

final class BooleanInputTest extends TestCase
{
    public function testBooleanInput(): void
    {
        $data = new PersonalForm();
        $data->terms(true);

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[terms]" value="0"><label><input type="checkbox" id="personalform-terms" name="PersonalForm[terms]" value="1" checked> Terms</label>
HTML;
        $html = BooleanInput::widget()
            ->type('checkbox')
            ->config($data, 'terms')
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testBooleanInputOptions(): void
    {
        $data = new PersonalForm();
        $data->terms(true);

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[terms]" value="0"><label><input type="checkbox" id="personalform-terms" class="customClass" name="PersonalForm[terms]" value="1" checked> Terms</label>
HTML;
        $html = BooleanInput::widget()
            ->type('checkbox')
            ->config($data, 'terms', ['class' => 'customClass'])
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testBooleanInputUnClosedByLabel(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[terms]" value="0"><input type="radio" id="personalform-terms" name="PersonalForm[terms]" value="1">
HTML;
        $html = BooleanInput::widget()
            ->type('radio')
            ->config($data, 'terms')
            ->enclosedByLabel(false)
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testBooleanInputUncheck(): void
    {
        $data = new PersonalForm();
        $data->terms(true);

        $expected = <<<'HTML'
<label><input type="radio" id="personalform-terms" name="PersonalForm[terms]" value="1" checked> Terms</label>
HTML;
        $html = BooleanInput::widget()
            ->type('radio')
            ->config($data, 'terms')
            ->uncheck()
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testBooleanInputLabelWithLabelOptions(): void
    {
        $data = new PersonalForm();
        $data->terms(true);

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[terms]" value="0"><label class="labelClass"><input type="radio" id="personalform-terms" name="PersonalForm[terms]" value="1" checked> customLabel</label>
HTML;
        $html = BooleanInput::widget()
            ->type('radio')
            ->config($data, 'terms')
            ->label('customLabel')
            ->labelOptions(['class' => 'labelClass'])
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testBooleanInputAutofocus(): void
    {
        $data = new PersonalForm();
        $data->terms(true);

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[terms]" value="0"><label><input type="radio" id="personalform-terms" name="PersonalForm[terms]" value="1" checked autofocus> Terms</label>
HTML;
        $html = BooleanInput::widget()
            ->type('radio')
            ->config($data, 'terms')
            ->autofocus()
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testBooleanInputDisabled(): void
    {
        $data = new PersonalForm();
        $data->terms(true);

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[terms]" value="0" disabled><label><input type="radio" id="personalform-terms" name="PersonalForm[terms]" value="1" checked disabled> Terms</label>
HTML;
        $html = BooleanInput::widget()
            ->type('radio')
            ->config($data, 'terms')
            ->disabled()
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testBooleanInputForm(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[terms]" value="0" form="form-id"><label><input type="radio" id="personalform-terms" name="PersonalForm[terms]" value="1" form="form-id"> Terms</label>
HTML;
        $html = BooleanInput::widget()
            ->type('radio')
            ->config($data, 'terms')
            ->form('form-id')
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testBooleanInputId(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[terms]" value="0"><label><input type="radio" id="custom-id" name="PersonalForm[terms]" value="1"> Terms</label>
HTML;
        $html = BooleanInput::widget()
            ->id('custom-id')
            ->type('radio')
            ->config($data, 'terms')
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testBooleanInputType(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[terms]" value="0"><label><input type="checkbox" id="custom-id" name="PersonalForm[terms]" value="1"> Terms</label>
HTML;
        $html = BooleanInput::widget()
            ->id('custom-id')
            ->type('checkbox')
            ->config($data, 'terms')
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testBooleanInputRequired(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[terms]" value="0"><label><input type="checkbox" id="custom-id" name="PersonalForm[terms]" value="1" required> Terms</label>
HTML;
        $html = BooleanInput::widget()
            ->id('custom-id')
            ->type('checkbox')
            ->config($data, 'terms')
            ->required()
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testBooleanInputCharset(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[имя]" value="0"><label><input type="checkbox" id="personalform-имя" name="PersonalForm[имя]" value="1"> Имя</label>
HTML;
        $html = BooleanInput::widget()
            ->type('checkbox')
            ->config($data, 'имя')
            ->charset('UTF-8')
            ->run();
        $this->assertEquals($expected, $html);
    }
}
