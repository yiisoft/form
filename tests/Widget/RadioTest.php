<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Tests\TestSupport\Form\TypeForm;
use Yiisoft\Form\Widget\Radio;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class RadioTest extends TestCase
{
    private TypeForm $formModel;

    public function testEnClosedByLabelWithFalse(): void
    {
        $expected = <<<'HTML'
        <input type="radio" id="typeform-int" name="TypeForm[int]" value="1">
        HTML;
        $this->assertSame(
            $expected,
            Radio::widget()->config($this->formModel, 'int')->enclosedByLabel(false)->value(1)->render(),
        );
    }

    public function testForceUncheckedValue(): void
    {
        $expected = <<<'HTML'
        <input type="hidden" name="TypeForm[int]" value="0"><label><input type="radio" id="typeform-int" name="TypeForm[int]" value="1"> Int</label>
        HTML;
        $this->assertSame(
            $expected,
            Radio::widget()->config($this->formModel, 'int')->uncheckValue(0)->value(1)->render(),
        );
    }

    public function testForm(): void
    {
        $expected = <<<'HTML'
        <label><input type="radio" id="typeform-int" name="TypeForm[int]" value="1" form="form-id"> Int</label>
        HTML;
        $this->assertSame(
            $expected,
            Radio::widget()->config($this->formModel, 'int')->form('form-id')->value(1)->render(),
        );
    }

    public function testImmutability(): void
    {
        $radio = Radio::widget();
        $this->assertNotSame($radio, $radio->enclosedByLabel(false));
        $this->assertNotSame($radio, $radio->form(''));
        $this->assertNotSame($radio, $radio->label(''));
        $this->assertNotSame($radio, $radio->labelAttributes());
    }

    public function testLabelWithLabelAttributes(): void
    {
        $expected = <<<'HTML'
        <label class="test-class"><input type="radio" id="typeform-int" name="TypeForm[int]" value="1"> Label:</label>
        HTML;
        $html = Radio::widget()
            ->config($this->formModel, 'int')
            ->label('Label:')
            ->labelAttributes(['class' => 'test-class'])
            ->value(1)
            ->render();
        $this->assertSame($expected, $html);
    }

    public function testRender(): void
    {
        $expected = <<<'HTML'
        <label><input type="radio" id="typeform-int" name="TypeForm[int]" value="1"> Int</label>
        HTML;
        $this->assertSame($expected, Radio::widget()->config($this->formModel, 'int')->value(1)->render());
    }

    public function testValues(): void
    {
        // value bool false
        $this->formModel->load(['TypeForm' => ['bool' => '1']]);
        $expected = <<<'HTML'
        <label><input type="radio" id="typeform-bool" name="TypeForm[bool]" value="0"> Bool</label>
        HTML;
        $this->assertSame($expected, Radio::widget()->config($this->formModel, 'bool')->value(false)->render());

        // value bool true
        $expected = <<<'HTML'
        <label><input type="radio" id="typeform-bool" name="TypeForm[bool]" value="1" checked> Bool</label>
        HTML;
        $this->assertSame($expected, Radio::widget()->config($this->formModel, 'bool')->value(true)->render());

        // value int 0
        $this->formModel->load(['TypeForm' => ['int' => '1']]);
        $expected = <<<'HTML'
        <label><input type="radio" id="typeform-int" name="TypeForm[int]" value="0"> Int</label>
        HTML;
        $this->assertSame($expected, Radio::widget()->config($this->formModel, 'int')->value(0)->render());

        // value int 1
        $expected = <<<'HTML'
        <label><input type="radio" id="typeform-int" name="TypeForm[int]" value="1" checked> Int</label>
        HTML;
        $this->assertSame($expected, Radio::widget()->config($this->formModel, 'int')->value(1)->render());

        // value string 'inactive'
        $this->formModel->load(['TypeForm' => ['string' => 'active']]);
        $expected = <<<'HTML'
        <label><input type="radio" id="typeform-string" name="TypeForm[string]" value="inactive"> String</label>
        HTML;
        $this->assertSame($expected, Radio::widget()->config($this->formModel, 'string')->value('inactive')->render());

        // value string 'active'
        $expected = <<<'HTML'
        <label><input type="radio" id="typeform-string" name="TypeForm[string]" value="active" checked> String</label>
        HTML;
        $this->assertSame($expected, Radio::widget()->config($this->formModel, 'string')->value('active')->render());

        // value null
        $this->formModel->load(['TypeForm' => ['toNull' => '']]);
        $expected = <<<'HTML'
        <label><input type="radio" id="typeform-tonull" name="TypeForm[toNull]" checked> To Null</label>
        HTML;
        $this->assertSame($expected, Radio::widget()->config($this->formModel, 'toNull')->value(null)->render());
    }

    public function testValueException(): void
    {
        $this->formModel->load(['TypeForm' => ['array' => []]]);
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Radio widget value can not be an iterable or an object.');
        Radio::widget()->config($this->formModel, 'array')->render();
    }

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer(), []);
        $this->formModel = new TypeForm();
    }
}
