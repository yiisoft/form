<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Tests\TestSupport\Form\TypeForm;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Widget\Field;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class FieldRadioTest extends TestCase
{
    use TestTrait;

    public function testAnyLabel(): void
    {
        $expected = <<<'HTML'
        <div>
        <input type="radio" id="typeform-bool" name="TypeForm[bool]" value="1">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->for($this->formModel, 'bool')
                ->radio(['enclosedByLabel()' => [false]], ['value' => true])
                ->label(['label()' => [null]])
                ->render(),
        );
    }

    public function testEnclosedByLabel(): void
    {
        // Enclosed by label `false`
        $expected = <<<'HTML'
        <div>
        <label for="typeform-bool">Bool</label>
        <input type="radio" id="typeform-bool" name="TypeForm[bool]" value="1">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->for($this->formModel, 'bool')
                ->radio(['enclosedByLabel()' => [false]], ['value' => true])
                ->render(),
        );

        // Enclosed by label `true`
        $expected = <<<'HTML'
        <div>
        <label><input type="radio" id="typeform-bool" name="TypeForm[bool]" value="1"> Bool</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->for($this->formModel, 'bool')->radio([], ['value' => true])->render(),
        );
    }

    public function testEnclosedByLabelWithLabelAttributes(): void
    {
        // Enclosed by label `false` with label attributes
        $expected = <<<'HTML'
        <div>
        <label class="test-class" for="typeform-bool">Bool</label>
        <input type="radio" id="typeform-bool" name="TypeForm[bool]" value="1">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->for($this->formModel, 'bool')
                ->radio(['enclosedByLabel()' => [false]], ['value' => true])
                ->label([], ['class' => 'test-class'])
                ->render(),
        );

        // Enclosed by label `true` with label attributes
        $expected = <<<'HTML'
        <div>
        <label class="test-class"><input type="radio" id="typeform-bool" name="TypeForm[bool]" value="1"> Bool</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->for($this->formModel, 'bool')
                ->radio(['labelAttributes()' => [['class' => 'test-class']]], ['value' => true])
                ->render(),
        );
    }

    public function testEnclosedByLabelCustomText(): void
    {
        // Enclosed by label `false` with custom text
        $expected = <<<'HTML'
        <div>
        <label for="typeform-bool">test-text-label</label>
        <input type="radio" id="typeform-bool" name="TypeForm[bool]" value="1">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->for($this->formModel, 'bool')
                ->radio(['enclosedByLabel()' => [false]], ['value' => true])
                ->label(['label()' => ['test-text-label']])
                ->render(),
        );

        // Enclosed by label `true` with custom text
        $expected = <<<'HTML'
        <div>
        <label><input type="radio" id="typeform-bool" name="TypeForm[bool]" value="1"> test-text-label</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->for($this->formModel, 'bool')
                ->radio(['label()' => ['test-text-label']], ['value' => true])
                ->render(),
        );
    }

    public function testRender(): void
    {
        $expected = <<<'HTML'
        <div>
        <label><input type="radio" id="typeform-int" name="TypeForm[int]" value="1"> Int</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->for($this->formModel, 'int')->radio([], ['value' => 1])->render()
        );
    }

    public function testUncheckValue(): void
    {
        $expected = <<<'HTML'
        <div>
        <input type="hidden" name="TypeForm[bool]" value="0"><label><input type="radio" id="typeform-bool" name="TypeForm[bool]" value="1"> Bool</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->for($this->formModel, 'bool')
                ->radio(['uncheckValue()' => ['0']], ['value' => true])
                ->render(),
        );
    }

    public function testValues(): void
    {
        // value bool false
        $this->formModel->setAttribute('bool', true);
        $expected = <<<'HTML'
        <div>
        <label><input type="radio" id="typeform-bool" name="TypeForm[bool]" value="0"> Bool</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->for($this->formModel, 'bool')->radio([], ['value' => false])->render(),
        );

        // value bool true
        $expected = <<<'HTML'
        <div>
        <label><input type="radio" id="typeform-bool" name="TypeForm[bool]" value="1" checked> Bool</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->for($this->formModel, 'bool')->radio([], ['value' => true])->render(),
        );

        // value int 0
        $this->formModel->setAttribute('int', 1);
        $expected = <<<'HTML'
        <div>
        <label><input type="radio" id="typeform-int" name="TypeForm[int]" value="0"> Int</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->for($this->formModel, 'int')->radio([], ['value' => 0])->render(),
        );

        // value int 1
        $expected = <<<'HTML'
        <div>
        <label><input type="radio" id="typeform-int" name="TypeForm[int]" value="1" checked> Int</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->for($this->formModel, 'int')->radio([], ['value' => 1])->render(),
        );

        // value string 'inactive'
        $this->formModel->setAttribute('string', 'active');
        $expected = <<<'HTML'
        <div>
        <label><input type="radio" id="typeform-string" name="TypeForm[string]" value="inactive"> String</label>
        <div>Write your text string.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->for($this->formModel, 'string')->radio([], ['value' => 'inactive'])->render(),
        );

        // value string 'active'
        $expected = <<<'HTML'
        <div>
        <label><input type="radio" id="typeform-string" name="TypeForm[string]" value="active" checked> String</label>
        <div>Write your text string.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->for($this->formModel, 'string')->radio([], ['value' => 'active'])->render(),
        );

        // value null
        $this->formModel->setAttribute('toNull', null);
        $expected = <<<'HTML'
        <div>
        <label><input type="radio" id="typeform-tonull" name="TypeForm[toNull]" checked> To Null</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->for($this->formModel, 'toNull')->radio([], ['value' => null])->render(),
        );
    }

    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Radio widget value can not be an iterable or an object.');
        Field::widget()->for($this->formModel, 'array')->radio()->render();
    }

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer(), []);
        $this->createFormModel(TypeForm::class);
    }
}
