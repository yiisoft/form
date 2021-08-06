<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\FormModelInterface;
use Yiisoft\Form\Tests\TestSupport\Form\TypeForm;
use Yiisoft\Form\Widget\CheckBox;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class CheckboxTest extends TestCase
{
    private FormModelInterface $formModel;

    public function testAutofocus(): void
    {
        $this->formModel->setAttribute('bool', true);
        $expected = <<<'HTML'
        <label><input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="1" checked autofocus> Bool</label>
        HTML;
        $this->assertSame($expected, CheckBox::widget()->config($this->formModel, 'bool')->autofocus()->render());
    }

    public function testDisabled(): void
    {
        $this->formModel->setAttribute('bool', true);
        $expected = <<<'HTML'
        <label><input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="1" checked disabled> Bool</label>
        HTML;
        $this->assertSame($expected, CheckBox::widget()->config($this->formModel, 'bool')->disabled()->render());
    }

    public function testEnclosedByLabel(): void
    {
        $this->assertSame(
            '<input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="0">',
            CheckBox::widget()->config($this->formModel, 'bool')->enclosedByLabel(false)->render(),
        );
    }

    public function testForceUncheckedValue(): void
    {
        $expected = <<<'HTML'
        <input type="hidden" name="TypeForm[bool]" value="0"><label><input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="0"> Bool</label>
        HTML;
        $this->assertSame(
            $expected,
            CheckBox::widget()->config($this->formModel, 'bool', ['forceUncheckedValue' => '0'])->render(),
        );
    }

    public function testForm(): void
    {
        $expected = <<<'HTML'
        <label><input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="0" form="form-id"> Bool</label>
        HTML;
        $this->assertSame(
            $expected,
            CheckBox::widget()->config($this->formModel, 'bool')->form('form-id')->render(),
        );
    }

    public function testImmutability(): void
    {
        $checkbox = CheckBox::widget();
        $this->assertNotSame($checkbox, $checkbox->autofocus());
        $this->assertNotSame($checkbox, $checkbox->disabled());
        $this->assertNotSame($checkbox, $checkbox->enclosedByLabel());
        $this->assertNotSame($checkbox, $checkbox->form(''));
        $this->assertNotSame($checkbox, $checkbox->label(''));
        $this->assertNotSame($checkbox, $checkbox->labelAttributes([]));
        $this->assertNotSame($checkbox, $checkbox->required());
    }

    public function testLabelWithLabelAttributes(): void
    {
        $this->formModel->setAttribute('bool', true);
        $expected = <<<'HTML'
        <label class="test-class"><input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="1" checked> test-text-label</label>
        HTML;
        $html = CheckBox::widget()
            ->config($this->formModel, 'bool')
            ->label('test-text-label')
            ->labelAttributes(['class' => 'test-class'])
            ->render();
        $this->assertSame($expected, $html);
    }

    public function testRender(): void
    {
        $this->formModel->setAttribute('bool', true);
        $expected = <<<'HTML'
        <label><input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="1" checked> Bool</label>
        HTML;
        $this->assertSame($expected, CheckBox::widget()->config($this->formModel, 'bool')->render());
    }

    public function testRequired(): void
    {
        $expected = <<<'HTML'
        <label><input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="0" required> Bool</label>
        HTML;
        $this->assertSame($expected, CheckBox::widget()->config($this->formModel, 'bool')->required()->render());
    }

    public function testValues(): void
    {
        // value bool false
        $this->formModel->setAttribute('bool', false);
        $expected = <<<'HTML'
        <label><input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="0"> Bool</label>
        HTML;
        $this->assertSame($expected, CheckBox::widget()->config($this->formModel, 'bool')->render());

        // value bool true
        $this->formModel->setAttribute('bool', true);
        $expected = <<<'HTML'
        <label><input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="1" checked> Bool</label>
        HTML;
        $this->assertSame($expected, CheckBox::widget()->config($this->formModel, 'bool')->render());

        // value int 0
        $this->formModel->setAttribute('int', 0);
        $expected = <<<'HTML'
        <label><input type="checkbox" id="typeform-int" name="TypeForm[int]" value="0"> Int</label>
        HTML;
        $this->assertSame($expected, CheckBox::widget()->config($this->formModel, 'int')->render());

        // value int 1
        $this->formModel->setAttribute('int', 1);
        $expected = <<<'HTML'
        <label><input type="checkbox" id="typeform-int" name="TypeForm[int]" value="1" checked> Int</label>
        HTML;
        $this->assertSame($expected, CheckBox::widget()->config($this->formModel, 'int')->render());

        // value string '0'
        $this->formModel->setAttribute('string', 0);
        $expected = <<<'HTML'
        <label><input type="checkbox" id="typeform-string" name="TypeForm[string]" value="0"> String</label>
        HTML;
        $this->assertSame($expected, CheckBox::widget()->config($this->formModel, 'string')->render());

        // value string '1'
        $this->formModel->setAttribute('string', 1);
        $expected = <<<'HTML'
        <label><input type="checkbox" id="typeform-string" name="TypeForm[string]" value="1" checked> String</label>
        HTML;
        $this->assertSame($expected, CheckBox::widget()->config($this->formModel, 'string')->render());

        // value null
        $this->formModel->setAttribute('toNull', null);
        $expected = <<<'HTML'
        <label><input type="checkbox" id="typeform-tonull" name="TypeForm[toNull]" value="0"> To Null</label>
        HTML;
        $this->assertSame($expected, CheckBox::widget()->config($this->formModel, 'toNull')->render());
    }

    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The value must be a bool|float|int|string|Stringable|null.');
        $html = CheckBox::widget()->config($this->formModel, 'array')->render();
    }

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer(), []);
        $this->formModel = new TypeForm();
    }
}
