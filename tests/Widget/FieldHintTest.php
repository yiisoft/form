<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\FormModelInterface;
use Yiisoft\Form\Tests\TestSupport\Form\PersonalForm;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Widget\Field;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class FieldHintTest extends TestCase
{
    use TestTrait;

    private PersonalForm $formModel;

    public function testAnyHint(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="personalform-name">Name</label>
        <input type="text" id="personalform-name" name="PersonalForm[name]" value="">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->formModel, 'name')->hint(['hint' => false])->render(),
        );
    }

    public function testHintCustom(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="personalform-name">Name</label>
        <input type="text" id="personalform-name" name="PersonalForm[name]" value="">
        <div class="test-class">Custom hint text.</div>
        </div>
        HTML;
        $html = Field::widget()
            ->config($this->formModel, 'name')
            ->hint(['class' => 'test-class', 'hint' => 'Custom hint text.'])
            ->render();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testRender(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="personalform-name">Name</label>
        <input type="text" id="personalform-name" name="PersonalForm[name]" value="">
        <div>Write your first name.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->formModel, 'name')->render(),
        );
    }

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer(), []);
        $this->formModel = new PersonalForm();
    }
}
