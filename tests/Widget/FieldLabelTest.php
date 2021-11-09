<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Tests\TestSupport\Form\PersonalForm;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Widget\Field;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class FieldLabelTest extends TestCase
{
    use TestTrait;

    private PersonalForm $formModel;

    public function testAnyLabel(): void
    {
        $expected = <<<'HTML'
        <div>
        <input type="text" id="personalform-email" name="PersonalForm[email]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->formModel, 'email')->label([], null, false)->render(),
        );
    }

    public function testFor(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="for-id">Email</label>
        <input type="text" id="personalform-email" name="PersonalForm[email]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->formModel, 'email')->label(['for' => 'for-id'])->render(),
        );
    }

    public function testLabel(): void
    {
        $expected = <<<'HTML'
        <div>
        <label class="test-class" for="personalform-email">Email:</label>
        <input type="text" id="personalform-email" name="PersonalForm[email]">
        </div>
        HTML;
        $html = Field::widget()
            ->config($this->formModel, 'email')
            ->label(['class' => 'test-class'], 'Email:')
            ->render();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testRender(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="personalform-email">Email</label>
        <input type="text" id="personalform-email" name="PersonalForm[email]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->config($this->formModel, 'email')->render());
    }

    public function testWithoutEncode(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="personalform-email">My&nbsp;Field</label>
        <input type="text" id="personalform-email" name="PersonalForm[email]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->formModel, 'email')->label([], 'My&nbsp;Field', false)->render(),
        );
    }

    public function testWithoutFor(): void
    {
        $expected = <<<'HTML'
        <div>
        <label>Email</label>
        <input type="text" id="personalform-email" name="PersonalForm[email]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->formModel, 'email')->label(['for' => null])->render(),
        );
    }

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer(), []);
        $this->formModel = new PersonalForm();
    }
}
