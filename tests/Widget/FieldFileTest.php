<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Tests\TestSupport\Form\TypeForm;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Widget\Field;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class FieldFileTest extends TestCase
{
    use TestTrait;

    public function testAccept(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-array">Array</label>
        <input type="file" id="typeform-array" name="TypeForm[array][]" accept="image/*">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->for($this->formModel, 'array')->file(['accept' => 'image/*'], [])->render(),
        );
    }

    public function testAttributes(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-array">Array</label>
        <input type="file" id="typeform-array" class="test-class" name="TypeForm[array][]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->for($this->formModel, 'array')->file(['class' => 'test-class'], [])->render(),
        );
    }

    public function testHiddenAttributes(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-array">Array</label>
        <input type="hidden" id="test-id" name="TypeForm[array]" value="0"><input type="file" id="typeform-array" name="TypeForm[array][]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->for($this->formModel, 'array')
                ->file([], ['uncheckValue()' => ['0'], 'hiddenAttributes()' => [['id' => 'test-id']]])
                ->render(),
        );
    }

    public function testMultiple(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-array">Array</label>
        <input type="file" id="typeform-array" name="TypeForm[array][]" multiple>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->for($this->formModel, 'array')->file(['multiple' => true], [])->render(),
        );
    }

    public function testRender(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-array">Array</label>
        <input type="file" id="typeform-array" name="TypeForm[array][]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->for($this->formModel, 'array')->file()->render(),
        );
    }

    public function testUncheckValue(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-array">Array</label>
        <input type="hidden" name="TypeForm[array]" value="0"><input type="file" id="typeform-array" name="TypeForm[array][]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->for($this->formModel, 'array')->file([], ['uncheckValue()' => ['0']])->render(),
        );
    }

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer(), []);
        $this->createFormModel(TypeForm::class);
    }
}
