<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Form\Tests\Widget;

use Yiisoft\Yii\Form\Tests\TestCase;
use Yiisoft\Yii\Form\Tests\Stub\PersonalForm;
use Yiisoft\Yii\Form\Widget\Error;

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
                'name' => null
            ]
        ];
    }

    public function testError(): void
    {
        $this->data->load($this->record);
        $this->data->validate();

        $expected = '<div>Value cannot be blank.</div>';
        $html = Error::widget()
            ->config($this->data, 'name')
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testErrorOptions(): void
    {
        $this->data->load($this->record);
        $this->data->validate();

        $expected = '<div class="customClass">Value cannot be blank.</div>';
        $html = Error::widget()
            ->config($this->data, 'name', ['class' => 'customClass'])
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testErrorErrorSource(): void
    {
        $this->data->load($this->record);
        $this->data->validate();

        $expected = '<div>This is custom error message.</div>';
        $html = Error::widget()
            ->config($this->data, 'name')
            ->errorSource([$this->data, 'customError'])
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testErrorNoEncode(): void
    {
        $this->data->load($this->record);
        $this->data->validate();

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
        $this->data->load($this->record);
        $this->data->validate();

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
}
