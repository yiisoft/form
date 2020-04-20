<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Html;

use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Tests\Stub\StubForm;
use Yiisoft\Form\Widget\Error;

final class ErrorTest extends TestCase
{
    public function testError(): void
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
        $created = Error::widget()
            ->data($form)
            ->attribute('fieldString')
            ->run();
        $this->assertEquals(
            $expected,
            $created,
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
        $created = Error::widget()
            ->data($form)
            ->attribute('fieldString')
            ->options(['errorSource' => [$form, 'customError']])
            ->run();
        $this->assertEquals(
            $expected,
            $created,
            'Custom error message generated by callback.'
        );
    }
}
