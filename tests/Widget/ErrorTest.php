<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use Yiisoft\Form\Tests\Stub\PersonalForm;
use Yiisoft\Form\Tests\Stub\ValidatorMock;
use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Widget\Error;
use Yiisoft\Validator\ValidatorInterface;

final class ErrorTest extends TestCase
{
    private PersonalForm $data;
    private array $record = [];

    protected function setUp(): void
    {
        parent::setUp();

        $this->data = new PersonalForm();
        $this->record = [
            'PersonalForm' =>
            [
                'name' => null,
            ],
        ];
    }

    public function testError(): void
    {
        $validator = $this->createValidatorMock();
        $this->data->load($this->record);

        $validator->validate($this->data);

        $expected = '<div>Value cannot be blank.</div>';
        $html = Error::widget()
            ->config($this->data, 'name')
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testErrorOptions(): void
    {
        $validator = $this->createValidatorMock();
        $this->data->load($this->record);

        $validator->validate($this->data);

        $expected = '<div class="customClass">Value cannot be blank.</div>';
        $html = Error::widget()
            ->config($this->data, 'name', ['class' => 'customClass'])
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testErrorErrorSource(): void
    {
        $validator = $this->createValidatorMock();
        $this->data->load($this->record);

        $validator->validate($this->data);

        $expected = '<div>This is custom error message.</div>';
        $html = Error::widget()
            ->config($this->data, 'name')
            ->errorSource([$this->data, 'customError'])
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testErrorNoEncode(): void
    {
        $validator = $this->createValidatorMock();
        $this->data->load($this->record);

        $validator->validate($this->data);

        $expected = '<div>(&#10006;) This is custom error message.</div>';
        $html = Error::widget()
            ->config($this->data, 'name')
            ->errorSource([$this->data, 'customErrorWithIcon'])
            ->noEncode()
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testErrorTag(): void
    {
        $validator = $this->createValidatorMock();
        $this->data->load($this->record);

        $validator->validate($this->data);

        $expected = 'Value cannot be blank.';
        $html = Error::widget()
            ->config($this->data, 'name')
            ->tag()
            ->run();
        $this->assertEquals($expected, $html);

        $expected = '<span>Value cannot be blank.</span>';
        $html = Error::widget()
            ->config($this->data, 'name')
            ->tag('span')
            ->run();
        $this->assertEquals($expected, $html);
    }

    private function createValidatorMock(): ValidatorInterface
    {
        return new ValidatorMock();
    }
}
