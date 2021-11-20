<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget\Factory;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Tests\TestSupport\Form\PersonalForm;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Widget\Error;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class ErrorTest extends TestCase
{
    use TestTrait;

    public function testMessage(): void
    {
        $this->assertSame(
            '<div>This is custom error message.</div>',
            Error::widget([
                'for()' => [$this->formModel, 'name'], 'message()' => ['This is custom error message.'],
            ])->render(),
        );
    }

    public function testMessageCallback(): void
    {
        $this->assertSame(
            '<div>This is custom error message.</div>',
            Error::widget([
                'for()' => [$this->formModel, 'name'],
                'messageCallback()' => [[$this->formModel, 'customError']],
            ])->render(),
        );
    }

    public function testMessageCallbackWithNoEncode(): void
    {
        $this->assertSame(
            '<div>(&#10006;) This is custom error message.</div>',
            Error::widget([
                'for()' => [$this->formModel, 'name'],
                'messageCallback()' => [[$this->formModel, 'customErrorWithIcon']],
                'encode()' => [false],
            ])->render(),
        );
    }

    public function testRender(): void
    {
        $this->assertSame(
            '<div>Value cannot be blank.</div>',
            Error::widget(['for()' => [$this->formModel, 'name']])->render()
        );
    }

    public function testTag(): void
    {
        $this->assertSame(
            'Value cannot be blank.',
            Error::widget(['for()' => [$this->formModel, 'name'], 'tag()' => ['']])->render(),
        );

        $this->assertSame(
            '<span>Value cannot be blank.</span>',
            Error::widget(['for()' => [$this->formModel, 'name'], 'tag()' => ['span']])->render(),
        );
    }

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer(), []);
        $this->createFormModel(PersonalForm::class);
        $this->formModel->load(['PersonalForm' => ['name' => '']]);
        $validator = $this->createValidatorMock();
        $validator->validate($this->formModel);
    }
}
