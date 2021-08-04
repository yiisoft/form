<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Tests\Stub\PersonalForm;
use Yiisoft\Form\Widget\CheckBox;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class CheckboxTest extends TestCase
{
    public function testAutofocus(): void
    {
        $data = new PersonalForm();
        $data->terms(true);

        $expected = <<<'HTML'
        <input type="hidden" name="PersonalForm[terms]" value="0"><label><input type="checkbox" id="personalform-terms" name="PersonalForm[terms]" value="1" checked autofocus> Terms</label>
        HTML;
        $this->assertSame($expected, CheckBox::widget()->config($data, 'terms')->autofocus()->render());
    }

    public function testDisabled(): void
    {
        $data = new PersonalForm();
        $data->terms(true);

        $expected = <<<'HTML'
        <input type="hidden" name="PersonalForm[terms]" value="0" disabled><label><input type="checkbox" id="personalform-terms" name="PersonalForm[terms]" value="1" checked disabled> Terms</label>
        HTML;
        $this->assertSame($expected, CheckBox::widget()->config($data, 'terms')->disabled()->render());
    }

    public function testEnclosedByLabel(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
        <input type="hidden" name="PersonalForm[terms]" value="0"><input type="checkbox" id="personalform-terms" name="PersonalForm[terms]" value="1">
        HTML;
        $this->assertSame($expected, CheckBox::widget()->config($data, 'terms')->enclosedByLabel(false)->render());
    }

    public function testForceUncheckedValue(): void
    {
        $data = new PersonalForm();
        $data->terms(true);

        $expected = <<<'HTML'
        <label><input type="checkbox" id="personalform-terms" name="PersonalForm[terms]" value="1" checked> Terms</label>
        HTML;
        $this->assertSame($expected, CheckBox::widget()->config($data, 'terms')->forceUncheckedValue(false)->render());
    }

    public function testForm(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
        <input type="hidden" name="PersonalForm[terms]" value="0" form="form-id"><label><input type="checkbox" id="personalform-terms" name="PersonalForm[terms]" value="1" form="form-id"> Terms</label>
        HTML;
        $this->assertSame($expected, CheckBox::widget()->config($data, 'terms')->form('form-id')->render());
    }

    public function testLabelWithLabelAttributes(): void
    {
        $data = new PersonalForm();
        $data->terms(true);

        $expected = <<<'HTML'
        <input type="hidden" name="PersonalForm[terms]" value="0"><label class="test-class"><input type="checkbox" id="personalform-terms" name="PersonalForm[terms]" value="1" checked> customLabel</label>
        HTML;
        $html = CheckBox::widget()
            ->config($data, 'terms')
            ->label('customLabel')
            ->labelAttributes(['class' => 'test-class'])
            ->render();
        $this->assertSame($expected, $html);
    }

    public function testRender(): void
    {
        $data = new PersonalForm();
        $data->terms(true);

        $expected = <<<'HTML'
        <input type="hidden" name="PersonalForm[terms]" value="0"><label><input type="checkbox" id="personalform-terms" name="PersonalForm[terms]" value="1" checked> Terms</label>
        HTML;
        $this->assertSame($expected, CheckBox::widget()->config($data, 'terms')->render());
    }

    public function testRequired(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
        <input type="hidden" name="PersonalForm[terms]" value="0"><label><input type="checkbox" id="personalform-terms" name="PersonalForm[terms]" value="1" required> Terms</label>
        HTML;
        $this->assertSame($expected, CheckBox::widget()->config($data, 'terms')->required()->render());
    }

    public function testValueException(): void
    {
        $data = new PersonalForm();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The value must be a bool|float|int|string|Stringable|null.');
        $html = CheckBox::widget()->config($data, 'citiesVisited')->render();
    }

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer(), []);
    }
}
