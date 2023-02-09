<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field;
use Yiisoft\Form\Tests\Support\Form\ContactForm;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Validator\Validator;
use Yiisoft\Widget\WidgetFactory;

final class ValidatorTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer());

        Field::initialize();
    }

    public function testValidatorFailsOne(): void
    {
        $formModel = new ContactForm();
        $validator = new Validator();
        $result = $validator->validate($formModel);

        if ($result->isValid() === false) {
            $this->assertSame(
                [
                    'email' => [
                        'Value cannot be blank.',
                    ],
                    'name' => [
                        'Value cannot be blank.',
                        'This value must contain at least 5 characters.',
                        'Value is invalid.',
                    ],
                    'subject' => [
                        'Value cannot be blank.',
                    ],
                ],
                $result->getErrorMessagesIndexedByAttribute(),
            );
        }
    }
}
