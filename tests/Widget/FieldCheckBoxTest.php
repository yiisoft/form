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

final class FieldCheckBoxTest extends TestCase
{
    use TestTrait;

    public function testAnyLabel(): void
    {
        $expected = <<<'HTML'
        <div>
        <input type="hidden" name="TypeForm[bool]" value="0"><input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="1">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->for($this->formModel, 'bool')
                ->checkbox(['value' => '1'], ['enclosedByLabel()' => [false]])
                ->label([], ['label()' => [null]])
                ->render(),
        );
    }

    public function testAttributes(): void
    {
        $expected = <<<'HTML'
        <div>
        <input type="hidden" name="TypeForm[bool]" value="0"><label><input type="checkbox" id="typeform-bool" class="test-class" name="TypeForm[bool]" value="1"> Bool</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->for($this->formModel, 'bool')
                ->checkbox(['class' => 'test-class', 'value' => '1'])
                ->render(),
        );
    }

    public function testEnclosedByLabel(): void
    {
        // Enclosed by label `false`
        $expected = <<<'HTML'
        <div>
        <label for="typeform-bool">Bool</label>
        <input type="hidden" name="TypeForm[bool]" value="0"><input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="1">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->for($this->formModel, 'bool')
                ->checkbox(['value' => '1'], ['enclosedByLabel()' => [false]])
                ->render(),
        );

        // Enclosed by label `true`
        $expected = <<<'HTML'
        <div>
        <input type="hidden" name="TypeForm[bool]" value="0"><label><input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="1"> Bool</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->for($this->formModel, 'bool')->checkbox(['value' => '1'])->render(),
        );
    }

    public function testEnclosedByLabelWithLabelAttributes(): void
    {
        // Enclosed by label `false` with label attributes
        $expected = <<<'HTML'
        <div>
        <label class="test-class" for="typeform-bool">Bool</label>
        <input type="hidden" name="TypeForm[bool]" value="0"><input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="1">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->for($this->formModel, 'bool')
                ->checkbox(['value' => '1'], ['enclosedByLabel()' => [false]])
                ->label(['class' => 'test-class'])
                ->render(),
        );

        // Enclosed by label `true` with label attributes
        $expected = <<<'HTML'
        <div>
        <input type="hidden" name="TypeForm[bool]" value="0"><label class="test-class"><input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="1"> Bool</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->for($this->formModel, 'bool')
                ->checkbox(['value' => '1'], ['labelAttributes()' => [['class' => 'test-class']]])
                ->render(),
        );
    }

    public function testEnclosedByLabelCustomText(): void
    {
        // Enclosed by label `false` with custom text
        $expected = <<<'HTML'
        <div>
        <label for="typeform-bool">test-text-label</label>
        <input type="hidden" name="TypeForm[bool]" value="0"><input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="1">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->for($this->formModel, 'bool')
                ->checkbox(['value' => '1'], ['enclosedByLabel()' => [false]])
                ->label([], ['label()' => ['test-text-label']])
                ->render(),
        );

        // Enclosed by label `true` with custom text
        $expected = <<<'HTML'
        <div>
        <input type="hidden" name="TypeForm[bool]" value="0"><label><input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="1"> test-text-label</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->for($this->formModel, 'bool')
                ->checkbox(['value' => '1'], ['label()' => ['test-text-label']])
                ->render(),
        );
    }

    public function testForm(): void
    {
        $expected = <<<'HTML'
        <div>
        <input type="hidden" name="TypeForm[bool]" value="0" form="form-id"><label><input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="1" form="form-id"> Bool</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->for($this->formModel, 'bool')
                ->checkbox(['form' => 'form-id', 'value' => '1'])
                ->render(),
        );
    }

    public function testRender(): void
    {
        $expected = <<<'HTML'
        <div>
        <input type="hidden" name="TypeForm[bool]" value="0"><label><input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="1"> Bool</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->for($this->formModel, 'bool')->checkbox(['value' => '1'])->render(),
        );
    }

    public function testUncheckValue(): void
    {
        $expected = <<<'HTML'
        <div>
        <input type="hidden" name="TypeForm[bool]" value="0"><label><input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="1"> Bool</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->for($this->formModel, 'bool')
                ->checkbox(['value' => '1'], ['uncheckValue()' => ['0']])
                ->render(),
        );
    }

    public function testValue(): void
    {
        $expected = <<<'HTML'
        <div>
        <input type="hidden" name="TypeForm[string]" value="inactive"><label><input type="checkbox" id="typeform-string" name="TypeForm[string]" value="active"> String</label>
        <div>Write your text string.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->for($this->formModel, 'string')
                ->checkbox(['value' => 'active'], ['uncheckValue()' => ['inactive']])
                ->render(),
        );
    }

    public function testValues(): void
    {
        // value bool false
        $this->formModel->setAttribute('bool', false);
        $expected = <<<'HTML'
        <div>
        <input type="hidden" name="TypeForm[bool]" value="0"><label><input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="1"> Bool</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->for($this->formModel, 'bool')->checkbox(['value' => '1'])->render(),
        );

        // value bool true
        $this->formModel->setAttribute('bool', true);
        $expected = <<<'HTML'
        <div>
        <input type="hidden" name="TypeForm[bool]" value="0"><label><input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="1" checked> Bool</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->for($this->formModel, 'bool')->checkbox(['value' => '1'])->render(),
        );

        // value int 0
        $this->formModel->setAttribute('int', 0);
        $expected = <<<'HTML'
        <div>
        <input type="hidden" name="TypeForm[int]" value="0"><label><input type="checkbox" id="typeform-int" name="TypeForm[int]" value="1"> Int</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->for($this->formModel, 'int')->checkbox(['value' => '1'])->render(),
        );

        // value int 1
        $this->formModel->setAttribute('int', 1);
        $expected = <<<'HTML'
        <div>
        <input type="hidden" name="TypeForm[int]" value="0"><label><input type="checkbox" id="typeform-int" name="TypeForm[int]" value="1" checked> Int</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->for($this->formModel, 'int')->checkbox(['value' => '1'])->render(),
        );

        // value string '0'
        $this->formModel->setAttribute('string', '0');
        $expected = <<<'HTML'
        <div>
        <input type="hidden" name="TypeForm[string]" value="0"><label><input type="checkbox" id="typeform-string" name="TypeForm[string]" value="1"> String</label>
        <div>Write your text string.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->for($this->formModel, 'string')->checkbox(['value' => '1'])->render(),
        );

        // value string '1'
        $this->formModel->setAttribute('string', '1');
        $expected = <<<'HTML'
        <div>
        <input type="hidden" name="TypeForm[string]" value="0"><label><input type="checkbox" id="typeform-string" name="TypeForm[string]" value="1" checked> String</label>
        <div>Write your text string.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->for($this->formModel, 'string')->checkbox(['value' => '1'])->render(),
        );

        // value null
        $this->formModel->setAttribute('toNull', null);
        $expected = <<<'HTML'
        <div>
        <input type="hidden" name="TypeForm[toNull]" value="0"><label><input type="checkbox" id="typeform-tonull" name="TypeForm[toNull]" value="1"> To Null</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->for($this->formModel, 'toNull')->checkbox(['value' => '1'])->render(),
        );
    }

    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Checkbox widget value can not be an iterable or an object.');
        Field::widget()->for($this->formModel, 'array')->checkbox()->render();
    }

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer(), []);
        $this->createFormModel(TypeForm::class);
    }
}
