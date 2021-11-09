<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Tests\TestSupport\Form\PersonalForm;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Tests\TestSupport\Validator\ValidatorMock;
use Yiisoft\Form\Widget\Field;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Validator\ValidatorInterface;
use Yiisoft\Widget\WidgetFactory;

final class FieldErrorTest extends TestCase
{
    use TestTrait;

    private PersonalForm $formModel;

    public function testMessageCustomText(): void
    {
        $validator = $this->createValidatorMock();
        $this->formModel->setAttribute('name', 'sam');
        $validator->validate($this->formModel);

        $expected = <<<'HTML'
        <div>
        <label for="personalform-name">Name</label>
        <input type="text" id="personalform-name" name="PersonalForm[name]" value="sam" minlength="4" required>
        <div>Write your first name.</div>
        <div>This is custom error message.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->config($this->formModel, 'name')
                ->error([], 'This is custom error message.')
                ->render(),
        );
    }

    public function testMessageCallback(): void
    {
        $validator = $this->createValidatorMock();
        $this->formModel->setAttribute('name', 'sam');
        $validator->validate($this->formModel);

        $expected = <<<'HTML'
        <div>
        <label for="personalform-name">Name</label>
        <input type="text" id="personalform-name" name="PersonalForm[name]" value="sam" minlength="4" required>
        <div>Write your first name.</div>
        <div>This is custom error message.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->config($this->formModel, 'name')
                ->error([], '', [$this->formModel, 'customError'])
                ->render(),
        );
    }

    public function testMessageCallbackWithNoEncode(): void
    {
        $validator = $this->createValidatorMock();
        $this->formModel->setAttribute('name', 'sam');
        $validator->validate($this->formModel);

        $expected = <<<'HTML'
        <div>
        <label for="personalform-name">Name</label>
        <input type="text" id="personalform-name" name="PersonalForm[name]" value="sam" minlength="4" required>
        <div>Write your first name.</div>
        <div>(&#10006;) This is custom error message.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->config($this->formModel, 'name')
                ->error([], '', [$this->formModel, 'customErrorWithIcon'], false)
                ->render(),
        );
    }

    public function testTabularErrors(): void
    {
        $validator = $this->createValidatorMock();
        $this->formModel->setAttribute('name', 'sam');
        $validator->validate($this->formModel);

        $expected = <<<'HTML'
        <div>
        <label for="personalform-0-name">Name</label>
        <input type="text" id="personalform-0-name" name="PersonalForm[0][name]" value="sam">
        <div>Write your first name.</div>
        <div>Is too short.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->config($this->formModel, '[0]name')->render());
    }

    public function testRender(): void
    {
        $validator = $this->createValidatorMock();
        $this->formModel->setAttribute('name', 'sam');
        $validator->validate($this->formModel);

        $expected = <<<'HTML'
        <div>
        <label for="personalform-name">Name</label>
        <input type="text" id="personalform-name" name="PersonalForm[name]" value="sam" minlength="4" required>
        <div>Write your first name.</div>
        <div>Is too short.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->formModel, 'name')->render(),
        );
    }

    public function testTag(): void
    {
        $validator = $this->createValidatorMock();
        $this->formModel->setAttribute('name', 'sam');
        $validator->validate($this->formModel);

        $expected = <<<'HTML'
        <div>
        <label for="personalform-name">Name</label>
        <input type="text" id="personalform-name" name="PersonalForm[name]" value="sam" minlength="4" required>
        <div>Write your first name.</div>
        <span>Is too short.</span>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->formModel, 'name')->error(['tag' => 'span'])->render(),
        );
    }

    public function testTagAttributes(): void
    {
        $validator = $this->createValidatorMock();
        $this->formModel->setAttribute('name', 'sam');
        $validator->validate($this->formModel);

        $expected = <<<'HTML'
        <div>
        <label for="personalform-name">Name</label>
        <input type="text" id="personalform-name" name="PersonalForm[name]" value="sam" minlength="4" required>
        <div>Write your first name.</div>
        <div class="testClass">Is too short.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->formModel, 'name')->error(['class' => 'testClass'])->render(),
        );
    }

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer(), []);
        $this->createFormModel(PersonalForm::class);
    }

    private function createValidatorMock(): ValidatorInterface
    {
        return new ValidatorMock();
    }
}
