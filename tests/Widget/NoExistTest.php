<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use InvalidArgumentException;
use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Tests\Stub\LoginForm;
use Yiisoft\Form\Widget\TextInput;

final class NoExistTest extends TestCase
{
    public function testNoExistWidget(): void
    {
        $data = new LoginForm();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Undefined property: "Yiisoft\Form\Tests\Stub\LoginForm::undefined_form_attribute".');

        (new TextInput())->config($data, 'undefined_form_attribute')->run();
    }
}
