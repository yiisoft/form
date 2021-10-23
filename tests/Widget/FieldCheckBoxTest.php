<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\FormModelInterface;
use Yiisoft\Form\Tests\TestSupport\Form\TypeForm;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Widget\Field;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class FieldCheckBoxTest extends TestCase
{
    use TestTrait;

    private FormModelInterface $formModel;

    public function testAnyLabel(): void
    {
        $expected = <<<'HTML'
        <div>
        <input type="hidden" name="TypeForm[bool]" value="0"><input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="1">
        </div>
        HTML;
        $html = Field::widget()
            ->config($this->formModel, 'bool')
            ->checkbox([], false)
            ->label(['label' => false])
            ->render();
        $this->assertEqualsWithoutLE($expected, $html);
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
            Field::widget()->config($this->formModel, 'bool')->checkbox([], false)->render(),
        );

        // Enclosed by label `true`
        $expected = <<<'HTML'
        <div>
        <input type="hidden" name="TypeForm[bool]" value="0"><label><input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="1"> Bool</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->formModel, 'bool')->checkbox([], true)->render(),
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
        $html = Field::widget()
            ->config($this->formModel, 'bool')
            ->checkbox([], false)
            ->label(['class' => 'test-class'])
            ->render();
        $this->assertEqualsWithoutLE($expected, $html);

        // Enclosed by label `true` with label attributes
        $expected = <<<'HTML'
        <div>
        <input type="hidden" name="TypeForm[bool]" value="0"><label class="test-class"><input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="1"> Bool</label>
        </div>
        HTML;
        $html = Field::widget()
            ->config($this->formModel, 'bool')
            ->checkbox(['labelAttributes' => ['class' => 'test-class']])
            ->render();
        $this->assertEqualsWithoutLE($expected, $html);
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
        $html = Field::widget()
            ->config($this->formModel, 'bool')
            ->checkbox([], false)
            ->label(['label' => 'test-text-label'])
            ->render();
        $this->assertEqualsWithoutLE($expected, $html);

        // Enclosed by label `true` with custom text
        $expected = <<<'HTML'
        <div>
        <input type="hidden" name="TypeForm[bool]" value="0"><label><input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="1"> test-text-label</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->formModel, 'bool')->checkbox(['label' => 'test-text-label'])->render(),
        );
    }

    public function testForceUncheckedValue(): void
    {
        $expected = <<<'HTML'
        <div>
        <input type="hidden" name="TypeForm[bool]" value="0"><label><input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="1"> Bool</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->formModel, 'bool')->checkbox(['forceUncheckedValue' => '0'])->render(),
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
            Field::widget()->config($this->formModel, 'bool')->checkbox(['form' => 'form-id'])->render(),
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
            Field::widget()->config($this->formModel, 'bool')->checkbox()->render(),
        );
    }

    public function testValues(): void
    {
        // value bool false
        $this->formModel->load(['TypeForm' => ['bool' => '0']]);
        $expected = <<<'HTML'
        <div>
        <input type="hidden" name="TypeForm[bool]" value="0"><label><input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="1"> Bool</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->formModel, 'bool')->checkbox()->render(),
        );

        // value bool true
        $this->formModel->load(['TypeForm' => ['bool' => '1']]);
        $expected = <<<'HTML'
        <div>
        <input type="hidden" name="TypeForm[bool]" value="0"><label><input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="1" checked> Bool</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->formModel, 'bool')->checkbox()->render(),
        );

        // value int 0
        $this->formModel->load(['TypeForm' => ['int' => '0']]);
        $expected = <<<'HTML'
        <div>
        <input type="hidden" name="TypeForm[int]" value="0"><label><input type="checkbox" id="typeform-int" name="TypeForm[int]" value="1"> Int</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->formModel, 'int')->checkbox()->render(),
        );

        // value int 1
        $this->formModel->load(['TypeForm' => ['int' => '1']]);
        $expected = <<<'HTML'
        <div>
        <input type="hidden" name="TypeForm[int]" value="0"><label><input type="checkbox" id="typeform-int" name="TypeForm[int]" value="1" checked> Int</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->formModel, 'int')->checkbox()->render(),
        );

        // value string '0'
        $this->formModel->load(['TypeForm' => ['string' => '0']]);
        $expected = <<<'HTML'
        <div>
        <input type="hidden" name="TypeForm[string]" value="0"><label><input type="checkbox" id="typeform-string" name="TypeForm[string]" value="1"> String</label>
        <div>Write your text string.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->formModel, 'string')->checkbox()->render(),
        );

        // value string '1'
        $this->formModel->load(['TypeForm' => ['string' => '1']]);
        $expected = <<<'HTML'
        <div>
        <input type="hidden" name="TypeForm[string]" value="0"><label><input type="checkbox" id="typeform-string" name="TypeForm[string]" value="1" checked> String</label>
        <div>Write your text string.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->formModel, 'string')->checkbox()->render(),
        );

        // value null
        $this->formModel->load(['TypeForm' => ['toNull' => '']]);
        $expected = <<<'HTML'
        <div>
        <input type="hidden" name="TypeForm[toNull]" value="0"><label><input type="checkbox" id="typeform-tonull" name="TypeForm[toNull]" value="1"> To Null</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->formModel, 'toNull')->checkbox()->render(),
        );
    }

    public function testValueException(): void
    {
        $this->formModel->load(['TypeForm' => ['array' => []]]);
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Checkbox widget value can not be an iterable or an object.');
        Field::widget()->config($this->formModel, 'array')->checkbox()->render();
    }

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer(), []);
        $this->formModel = new TypeForm();
    }
}
