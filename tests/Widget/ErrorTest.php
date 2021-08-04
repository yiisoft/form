<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Tests\Stub\PersonalForm;
use Yiisoft\Form\Tests\Stub\ValidatorMock;
use Yiisoft\Form\Widget\Error;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Validator\ValidatorInterface;
use Yiisoft\Widget\WidgetFactory;

final class ErrorTest extends TestCase
{
    private PersonalForm $data;
    private array $record = [];

    public function testErrorSource(): void
    {
        $validator = $this->createValidatorMock();
        $this->data->load($this->record);
        $validator->validate($this->data);
        $this->assertSame(
            '<div>This is custom error message.</div>',
            Error::widget()->config($this->data, 'name')->errorSource([$this->data, 'customError'])->render(),
        );
    }

    public function testNoEncode(): void
    {
        $validator = $this->createValidatorMock();
        $this->data->load($this->record);
        $validator->validate($this->data);
        $this->assertSame(
            '<div>(&#10006;) This is custom error message.</div>',
            Error::widget()->config($this->data, 'name', ['encode' => false])->errorSource([$this->data, 'customErrorWithIcon'])->render(),
        );
    }

    public function testRender(): void
    {
        $validator = $this->createValidatorMock();
        $this->data->load($this->record);
        $validator->validate($this->data);
        $this->assertSame('<div>Value cannot be blank.</div>', Error::widget()->config($this->data, 'name')->render());
    }

    public function testTag(): void
    {
        $validator = $this->createValidatorMock();
        $this->data->load($this->record);
        $validator->validate($this->data);
        $this->assertSame('Value cannot be blank.', Error::widget()->config($this->data, 'name')->tag()->render());
        $this->assertSame(
            '<span>Value cannot be blank.</span>',
            Error::widget()->config($this->data, 'name')->tag('span')->render(),
        );
    }

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer(), []);

        $this->data = new PersonalForm();

        $this->record = [
            'PersonalForm' =>
            [
                'name' => null,
            ],
        ];
    }

    private function createValidatorMock(): ValidatorInterface
    {
        return new ValidatorMock();
    }
}
