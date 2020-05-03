<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Tests\Stub\PersonalForm;
use Yiisoft\Form\Widget\Radio;

final class RadioTest extends TestCase
{
    public function testRadio(): void
    {
        $data = new PersonalForm();
        $data->terms(true);

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[terms]" value="0"><label><input type="radio" id="personalform-terms" name="PersonalForm[terms]" value="1" checked> Terms</label>
HTML;
        $html = Radio::widget()
            ->config($data, 'terms')
            ->uncheck(true)
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testRadioOptions(): void
    {
        $data = new PersonalForm();
        $data->terms(true);

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[terms]" value="0"><label><input type="radio" id="personalform-terms" class="customClass" name="PersonalForm[terms]" value="1" checked> Terms</label>
HTML;
        $html = Radio::widget()
            ->config($data, 'terms', ['class' => 'customClass'])
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testRadioUnClosedByLabel(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[terms]" value="0"><input type="radio" id="personalform-terms" name="PersonalForm[terms]" value="1">
HTML;
        $html = Radio::widget()
            ->config($data, 'terms')
            ->enClosedByLabel(false)
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testRadioUncheck(): void
    {
        $data = new PersonalForm();
        $data->terms(true);

        $expected = <<<'HTML'
<label><input type="radio" id="personalform-terms" name="PersonalForm[terms]" value="1" checked> Terms</label>
HTML;
        $html = Radio::widget()
            ->config($data, 'terms')
            ->uncheck(false)
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testRadioLabelWithLabelOptions(): void
    {
        $data = new PersonalForm();
        $data->terms(true);

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[terms]" value="0"><label class="labelClass"><input type="radio" id="personalform-terms" name="PersonalForm[terms]" value="1" checked> customLabel</label>
HTML;
        $html = Radio::widget()
            ->config($data, 'terms')
            ->label('customLabel')
            ->labelOptions(['class' => 'labelClass'])
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testRadioAutofocus(): void
    {
        $data = new PersonalForm();
        $data->terms(true);

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[terms]" value="0"><label><input type="radio" id="personalform-terms" name="PersonalForm[terms]" value="1" checked autofocus> Terms</label>
HTML;
        $html = Radio::widget()
            ->config($data, 'terms')
            ->autofocus()
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testRadioDisabled(): void
    {
        $data = new PersonalForm();
        $data->terms(true);

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[terms]" value="0" disabled><label><input type="radio" id="personalform-terms" name="PersonalForm[terms]" value="1" checked disabled> Terms</label>
HTML;
        $html = Radio::widget()
            ->config($data, 'terms')
            ->disabled()
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testRadioForm(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[terms]" value="0" form="form-id"><label><input type="radio" id="personalform-terms" name="PersonalForm[terms]" value="1" form="form-id"> Terms</label>
HTML;
        $html = Radio::widget()
            ->config($data, 'terms')
            ->form('form-id')
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testRadioId(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[terms]" value="0"><label><input type="radio" id="custom-id" name="PersonalForm[terms]" value="1"> Terms</label>
HTML;
        $html = Radio::widget()
            ->id('custom-id')
            ->config($data, 'terms')
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testRadioRequired(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[terms]" value="0"><label><input type="radio" id="personalform-terms" name="PersonalForm[terms]" value="1" required> Terms</label>
HTML;
        $html = Radio::widget()
            ->config($data, 'terms')
            ->required(true)
            ->run();
        $this->assertEquals($expected, $html);
    }
}
