<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Tests\Stub\PersonalForm;
use Yiisoft\Form\Widget\FileInput;

final class FileInputTest extends TestCase
{
    public function testFileInput(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[attachFiles]" value=""><input type="file" id="personalform-attachfiles" name="PersonalForm[attachFiles]">
HTML;
        $html = FileInput::widget()
            ->config($data, 'attachFiles')
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testFileInputOptions(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="hidden" name="fileName" value=""><input type="file" id="personalform-attachfiles" class="customClass" name="fileName">
HTML;
        $html = FileInput::widget()
            ->config($data, 'attachFiles', ['class' => 'customClass', 'name' => 'fileName'])
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testFileInputAccept(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[attachFiles]" value=""><input type="file" id="personalform-attachfiles" name="PersonalForm[attachFiles]" accept="image/*">
HTML;
        $html = FileInput::widget()
            ->config($data, 'attachFiles')
            ->accept('image/*')
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testFileInputAutoFocus(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[attachFiles]" value=""><input type="file" id="personalform-attachfiles" name="PersonalForm[attachFiles]" autofocus>
HTML;
        $html = FileInput::widget()
            ->config($data, 'attachFiles')
            ->autofocus()
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testFileInputDisabled(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[attachFiles]" value="" disabled><input type="file" id="personalform-attachfiles" name="PersonalForm[attachFiles]" disabled>
HTML;
        $html = FileInput::widget()
            ->config($data, 'attachFiles')
            ->disabled()
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testFileInputhiddenOptions(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="hidden" id="specific-id" name="PersonalForm[attachFiles]" value=""><input type="file" id="personalform-attachfiles" name="PersonalForm[attachFiles]">
HTML;
        $html = FileInput::widget()
            ->config($data, 'attachFiles')
            ->hiddenOptions(['id' => 'specific-id'])
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testFileInputMultiple(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[attachFiles]" value=""><input type="file" id="personalform-attachfiles" name="PersonalForm[attachFiles]" multiple>
HTML;
        $html = FileInput::widget()
            ->config($data, 'attachFiles')
            ->multiple()
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testFileInputRequired(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[attachFiles]" value=""><input type="file" id="personalform-attachfiles" name="PersonalForm[attachFiles]" required>
HTML;
        $html = FileInput::widget()
            ->config($data, 'attachFiles')
            ->required()
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testFileInputTabIndex(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="hidden" name="PersonalForm[attachFiles]" value=""><input type="file" id="personalform-attachfiles" name="PersonalForm[attachFiles]" tabindex="0">
HTML;
        $html = FileInput::widget()
            ->config($data, 'attachFiles')
            ->tabIndex()
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testFileInputNoHiddenInput(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="file" id="personalform-attachfiles" name="PersonalForm[attachFiles]">
HTML;
        $html = FileInput::widget()
            ->config($data, 'attachFiles')
            ->noHiddenInput(true)
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }
}
