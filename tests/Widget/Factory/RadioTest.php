<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget\Factory;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Tests\TestSupport\Form\TypeForm;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Widget\Radio;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class RadioTest extends TestCase
{
    use TestTrait;

    public function testEnClosedByLabelWithFalse(): void
    {
        $expected = <<<'HTML'
        <input type="radio" id="typeform-int" name="TypeForm[int]" value="1">
        HTML;
        $this->assertSame(
            $expected,
            Radio::widget(
                ['for()' => [$this->formModel, 'int'], 'enclosedByLabel()' => [false], 'value()' => [1]]
            )->render(),
        );
    }

    public function testForceUncheckedValue(): void
    {
        $expected = <<<'HTML'
        <input type="hidden" name="TypeForm[int]" value="0"><label><input type="radio" id="typeform-int" name="TypeForm[int]" value="1"> Int</label>
        HTML;
        $this->assertSame(
            $expected,
            Radio::widget(['for()' => [$this->formModel, 'int'], 'uncheckValue()' => [0], 'value()' => [1]])->render(),
        );
    }

    public function testLabelWithLabelAttributes(): void
    {
        $expected = <<<'HTML'
        <label class="test-class"><input type="radio" id="typeform-int" name="TypeForm[int]" value="1"> Label:</label>
        HTML;
        $this->assertSame(
            $expected,
            Radio::widget([
                'for()' => [$this->formModel, 'int'],
                'label()' => ['Label:'],
                'labelAttributes()' => [['class' => 'test-class']],
                'value()' => [1],
            ])->render(),
        );
    }

    public function testRender(): void
    {
        $expected = <<<'HTML'
        <label><input type="radio" id="typeform-int" name="TypeForm[int]" value="1"> Int</label>
        HTML;
        $this->assertSame(
            $expected,
            Radio::widget(['for()' => [$this->formModel, 'int'], 'value()' => [1]])->render(),
        );
    }

    public function testValues(): void
    {
        // value bool false
        $this->formModel->setAttribute('bool', true);
        $expected = <<<'HTML'
        <label><input type="radio" id="typeform-bool" name="TypeForm[bool]" value="0"> Bool</label>
        HTML;
        $this->assertSame(
            $expected,
            Radio::widget(['for()' => [$this->formModel, 'bool'], 'value()' => ['0']])->render(),
        );

        // value bool true
        $expected = <<<'HTML'
        <label><input type="radio" id="typeform-bool" name="TypeForm[bool]" value="1" checked> Bool</label>
        HTML;
        $this->assertSame(
            $expected,
            Radio::widget(['for()' => [$this->formModel, 'bool'], 'value()' => ['1']])->render(),
        );

        // value int 0
        $this->formModel->setAttribute('int', 1);
        $expected = <<<'HTML'
        <label><input type="radio" id="typeform-int" name="TypeForm[int]" value="0"> Int</label>
        HTML;
        $this->assertSame(
            $expected,
            Radio::widget(['for()' => [$this->formModel, 'int'], 'value()' => [0]])->render(),
        );

        // value int 1
        $expected = <<<'HTML'
        <label><input type="radio" id="typeform-int" name="TypeForm[int]" value="1" checked> Int</label>
        HTML;
        $this->assertSame(
            $expected,
            Radio::widget(['for()' => [$this->formModel, 'int'], 'value()' => [1]])->render(),
        );

        // value string 'inactive'
        $this->formModel->setAttribute('string', 'active');
        $expected = <<<'HTML'
        <label><input type="radio" id="typeform-string" name="TypeForm[string]" value="inactive"> String</label>
        HTML;
        $this->assertSame(
            $expected,
            Radio::widget(['for()' => [$this->formModel, 'string'], 'value()' => ['inactive']])->render(),
        );

        // value string 'active'
        $expected = <<<'HTML'
        <label><input type="radio" id="typeform-string" name="TypeForm[string]" value="active" checked> String</label>
        HTML;
        $this->assertSame(
            $expected,
            Radio::widget(['for()' => [$this->formModel, 'string'], 'value()' => ['active']])->render(),
        );

        // value null
        $expected = <<<'HTML'
        <label><input type="radio" id="typeform-tonull" name="TypeForm[toNull]" checked> To Null</label>
        HTML;
        $this->assertSame(
            $expected,
            Radio::widget(['for()' => [$this->formModel, 'toNull'], 'value()' => [null]])->render(),
        );
    }

    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Radio widget value can not be an iterable or an object.');
        Radio::widget(['for()' => [$this->formModel, 'array']])->render();
    }

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer(), []);
        $this->createFormModel(TypeForm::class);
    }
}
