<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\FormModelInterface;
use Yiisoft\Form\Tests\Stub\ValidatorMock;
use Yiisoft\Form\Tests\TestSupport\Form\TypeForm;
use Yiisoft\Form\Widget\Error;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Validator\ValidatorInterface;
use Yiisoft\Widget\WidgetFactory;

final class ErrorTest extends TestCase
{
    private array $record = [];
    private FormModelInterface $formModel;

    public function testMessage(): void
    {
        $html = Error::widget()->config($this->formModel, 'name')->message('This is custom error message.')->render();
        $this->assertSame('<div>This is custom error message.</div>', $html);
    }

    public function testMessageCallback(): void
    {
        $html = Error::widget()
            ->config($this->formModel, 'string')
            ->messageCallback([$this->formModel, 'customError'])
            ->render();
        $this->assertSame('<div>This is custom error message.</div>', $html);
    }

    public function testMessageCallbackWithNoEncode(): void
    {
        $html = Error::widget()
            ->config($this->formModel, 'string', ['encode' => false])
            ->messageCallback([$this->formModel, 'customErrorWithIcon'])
            ->render();
        $this->assertSame('<div>(&#10006;) This is custom error message.</div>', $html);
    }

    public function testRender(): void
    {
        $this->assertSame(
            '<div>Value cannot be blank.</div>',
            Error::widget()->config($this->formModel, 'string')->render(),
        );
    }

    public function testTag(): void
    {
        $this->assertSame(
            'Value cannot be blank.',
            Error::widget()->config($this->formModel, 'string')->tag()->render(),
        );
        $this->assertSame(
            '<span>Value cannot be blank.</span>',
            Error::widget()->config($this->formModel, 'string')->tag('span')->render(),
        );
    }

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer(), []);
        $this->formModel = new TypeForm();
        $this->formModel->load(['TypeForm' => ['string' => null]]);
        $validator = $this->createValidatorMock();
        $validator->validate($this->formModel);
    }

    private function createValidatorMock(): ValidatorInterface
    {
        return new ValidatorMock();
    }
}
