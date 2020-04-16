<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Html;

use Yiisoft\Form\Html\ErrorForm;
use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Tests\Stub\StubForm;

final class ErrorFormTest extends TestCase
{
    public function testErrorForm()
    {
        $data = [
            'StubForm' =>
            [
                'fieldString' => null
            ]
        ];

        $form = new StubForm();

        $form->load($data);
        $form->validate();

        $expected = '<div>Value cannot be blank.</div>';
        $this->assertEquals(
            $expected,
            ErrorForm::create($form, 'fieldString'),
            'Default error message after calling $model->getFirstError().'
        );

        $data = [
            'StubForm' =>
            [
                'fieldString' => 'red'
            ]
        ];

        $form->load($data);
        $form->validate();

        $expected = '<div>This is custom error message.</div>';
        $this->assertEquals(
            $expected,
            ErrorForm::create($form, 'fieldString', ['errorSource' => [$form, 'customError']]),
            'Custom error message generated by callback.'
        );
    }
}
