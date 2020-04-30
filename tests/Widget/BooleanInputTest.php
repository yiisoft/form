<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Tests\Stub\PersonalForm;
use Yiisoft\Form\Widget\BooleanInput;

final class BooleanInputTest extends TestCase
{
    public function testBooleanInputDefaultOptions(): void
    {
        $data = new PersonalForm();

        $data->terms(true);
        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[terms]" value="0" form="terms"><label><input type="checkbox" id="personalform-terms" name="PersonalForm[terms]" value="1" form="terms" checked> Terms</label>
HTML;
        $html = BooleanInput::widget()
            ->type('checkbox')
            ->config($data, 'terms')
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testBooleanInputCustomOptions(): void
    {
        $data = new PersonalForm();

        /** options(): options for tag generate for BooleanInput::class */
        $data->terms(true);
        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[terms]" value="0" form="terms"><label><input type="checkbox" id="personalform-terms" class="customClass" name="PersonalForm[terms]" value="1" form="terms" checked> Terms</label>
HTML;
        $html = BooleanInput::widget()
            ->type('checkbox')
            ->config($data, 'terms', ['class' => 'customClass'])
            ->run();
        $this->assertEquals($expected, $html);

        /** noForm(): disabled attribute form */
        $data->terms(true);
        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[terms]" value="0"><label><input type="checkbox" id="personalform-terms" name="PersonalForm[terms]" value="1" checked> Terms</label>
HTML;
        $html = BooleanInput::widget()
            ->type('checkbox')
            ->config($data, 'terms')
            ->noForm()
            ->run();
        $this->assertEquals($expected, $html);

        /** noLabel(): disabled tag label */
        $data->terms(false);
        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[terms]" value="0" form="terms"><input type="radio" id="personalform-terms" name="PersonalForm[terms]" value="1" form="terms">
HTML;
        $html = BooleanInput::widget()
            ->type('radio')
            ->config($data, 'terms')
            ->noLabel()
            ->run();
        $this->assertEquals($expected, $html);

        /** uncheck(false): disabled tag input hidden */
        $data->terms(true);
        $expected = <<<'HTML'
<label><input type="radio" id="personalform-terms" name="PersonalForm[terms]" value="1" form="terms" checked> Terms</label>
HTML;
        $html = BooleanInput::widget()
            ->type('radio')
            ->config($data, 'terms')
            ->uncheck(false)
            ->run();
        $this->assertEquals($expected, $html);

        /**
         * label: add custom label
         * labelOptions: add options labels
         */
        $data->terms(true);
        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[terms]" value="0" form="terms"><label class="labelClass"><input type="radio" id="personalform-terms" name="PersonalForm[terms]" value="1" form="terms" checked> customLabel</label>
HTML;
        $html = BooleanInput::widget()
            ->type('radio')
            ->config($data, 'terms')
            ->label('customLabel')
            ->labelOptions(['class' => 'labelClass'])
            ->run();
        $this->assertEquals($expected, $html);

        /** autofocus(): enabled attribute autofocus */
        $data->terms(true);
        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[terms]" value="0" form="terms"><label><input type="radio" id="personalform-terms" name="PersonalForm[terms]" value="1" form="terms" checked autofocus> Terms</label>
HTML;
        $html = BooleanInput::widget()
            ->type('radio')
            ->config($data, 'terms')
            ->autofocus()
            ->run();
        $this->assertEquals($expected, $html);


        /** disabled(): add attribute disabled for tag input */
        $data->terms(true);
        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[terms]" value="0" form="terms" disabled><label><input type="radio" id="personalform-terms" name="PersonalForm[terms]" value="1" form="terms" checked disabled> Terms</label>
HTML;
        $html = BooleanInput::widget()
            ->type('radio')
            ->config($data, 'terms')
            ->disabled()
            ->run();
        $this->assertEquals($expected, $html);

        /** form(): add attribute custom form for tag input */
        $data->terms(false);
        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[terms]" value="0" form="customForm"><label><input type="radio" id="personalform-terms" name="PersonalForm[terms]" value="1" form="customForm"> Terms</label>
HTML;
        $html = BooleanInput::widget()
            ->type('radio')
            ->config($data, 'terms')
            ->form('customForm')
            ->run();
        $this->assertEquals($expected, $html);

        /** id(): add custom id for tag input */
        $data->terms(false);
        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[terms]" value="0" form="terms"><label><input type="radio" id="custom-id" name="PersonalForm[terms]" value="1" form="terms"> Terms</label>
HTML;
        $html = BooleanInput::widget()
            ->id('custom-id')
            ->type('radio')
            ->config($data, 'terms')
            ->run();
        $this->assertEquals($expected, $html);

        /** type(): Type of control generated CheckBox, Radio */
        $data->terms(false);
        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[terms]" value="0" form="terms"><label><input type="checkbox" id="custom-id" name="PersonalForm[terms]" value="1" form="terms"> Terms</label>
HTML;
        $html = BooleanInput::widget()
            ->id('custom-id')
            ->type('checkbox')
            ->config($data, 'terms')
            ->run();
        $this->assertEquals($expected, $html);
    }
}
