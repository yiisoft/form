<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use Yiisoft\Form\Tests\Stub\PersonalForm;
use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Widget\TextArea;

final class TextAreaTest extends TestCase
{
    public function testTextArea(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<textarea id="personalform-address" name="PersonalForm[address]" placeholder="Address"></textarea>
HTML;
        $html = TextArea::widget()
            ->config($data, 'address')
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testTextAreaOptions(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<textarea id="personalform-address" class="customClass" name="PersonalForm[address]" placeholder="Address"></textarea>
HTML;
        $html = TextArea::widget()
            ->config($data, 'address', ['class' => 'customClass'])
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testTextAreaAutofocus(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<textarea id="personalform-address" name="PersonalForm[address]" autofocus placeholder="Address"></textarea>
HTML;
        $html = TextArea::widget()
            ->config($data, 'address')
            ->autofocus()
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testTextAreaDisabled(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<textarea id="personalform-address" name="PersonalForm[address]" disabled placeholder="Address"></textarea>
HTML;
        $html = TextArea::widget()
            ->config($data, 'address')
            ->disabled()
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testTextAreaForm(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<textarea id="personalform-address" name="PersonalForm[address]" form="form-id" placeholder="Address"></textarea>
HTML;
        $html = TextArea::widget()
            ->config($data, 'address')
            ->form('form-id')
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testTextAreaMinLength(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<textarea id="personalform-address" name="PersonalForm[address]" minlength="10" placeholder="Address"></textarea>
HTML;
        $html = TextArea::widget()
            ->config($data, 'address')
            ->minlength(10)
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testTextAreaMaxLength(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<textarea id="personalform-address" name="PersonalForm[address]" maxlength="50" placeholder="Address"></textarea>
HTML;
        $html = TextArea::widget()
            ->config($data, 'address')
            ->maxlength(50)
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testTextAreaNoPlaceholder(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<textarea id="personalform-address" name="PersonalForm[address]"></textarea>
HTML;
        $html = TextArea::widget()
            ->config($data, 'address')
            ->noPlaceholder()
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testTextAreaPlaceholder(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<textarea id="personalform-address" name="PersonalForm[address]" placeholder="Home address."></textarea>
HTML;
        $html = TextArea::widget()
            ->config($data, 'address')
            ->placeholder('Home address.')
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testTextAreaReadOnly(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<textarea id="personalform-address" name="PersonalForm[address]" readonly placeholder="Address"></textarea>
HTML;
        $html = TextArea::widget()
            ->config($data, 'address')
            ->readOnly()
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testTextAreaSpellCheck(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<textarea id="personalform-address" name="PersonalForm[address]" spellcheck placeholder="Address"></textarea>
HTML;
        $html = TextArea::widget()
            ->config($data, 'address')
            ->spellcheck()
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testTextAreaRequired(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<textarea id="personalform-address" name="PersonalForm[address]" required placeholder="Address"></textarea>
HTML;
        $html = TextArea::widget()
            ->config($data, 'address')
            ->required()
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testTextAreaTabIndex(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<textarea id="personalform-address" name="PersonalForm[address]" tabindex="0" placeholder="Address"></textarea>
HTML;
        $html = TextArea::widget()
            ->config($data, 'address')
            ->tabIndex()
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testTextAreaTitle(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<textarea id="personalform-address" name="PersonalForm[address]" title="Enter the city, municipality, avenue, house or apartment number." placeholder="Address"></textarea>
HTML;
        $html = TextArea::widget()
            ->config($data, 'address')
            ->title('Enter the city, municipality, avenue, house or apartment number.')
            ->run();
        $this->assertEquals($expected, $html);
    }
}
