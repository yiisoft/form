<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Tests\Stub\PersonalForm;
use Yiisoft\Form\Widget\Input;

final class InputTest extends TestCase
{
    public function testInput(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="text" id="personalform-name" name="PersonalForm[name]" placeholder="Name">
HTML;
        $html = Input::widget()
            ->type('text')
            ->config($data, 'name')
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testInputOptions(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="text" id="personalform-name" class="customClass" name="PersonalForm[name]" placeholder="Name">
HTML;
        $html = Input::widget()
            ->type('text')
            ->config($data, 'name', ['class' => 'customClass'])
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testInputAutofocus(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="text" id="personalform-name" name="PersonalForm[name]" autofocus placeholder="Name">
HTML;
        $html = Input::widget()
            ->type('text')
            ->config($data, 'name')
            ->autofocus()
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testInputDisabled(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="text" id="personalform-name" name="PersonalForm[name]" disabled placeholder="Name">
HTML;
        $html = Input::widget()
            ->type('text')
            ->config($data, 'name')
            ->disabled()
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testInputform(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="text" id="personalform-name" name="PersonalForm[name]" form="form-id" placeholder="Name">
HTML;
        $html = Input::widget()
            ->type('text')
            ->config($data, 'name')
            ->form('form-id')
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testInputNoPlaceHolder(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="text" id="personalform-name" name="PersonalForm[name]">
HTML;
        $html = Input::widget()
            ->type('text')
            ->config($data, 'name')
            ->noPlaceHolder()
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testInputPlaceHolderCustom(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="text" id="personalform-name" name="PersonalForm[name]" placeholder="Custom placeholder.">
HTML;
        $html = Input::widget()
            ->type('text')
            ->config($data, 'name')
            ->placeHolder('Custom placeholder.')
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testInputRequired(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="text" id="personalform-name" name="PersonalForm[name]" required placeholder="Name">
HTML;
        $html = Input::widget()
            ->type('text')
            ->config($data, 'name')
            ->required()
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testInputTabIndex(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="text" id="personalform-name" name="PersonalForm[name]" tabindex="1" placeholder="Name">
HTML;
        $html = Input::widget()
            ->type('text')
            ->config($data, 'name')
            ->tabindex(1)
            ->run();
        $this->assertEquals($expected, $html);
    }
}
