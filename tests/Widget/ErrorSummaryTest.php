<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Tests\Stub\PersonalForm;
use Yiisoft\Form\Tests\Stub\ValidatorMock;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Widget\ErrorSummary;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Validator\ValidatorInterface;
use Yiisoft\Widget\WidgetFactory;

final class ErrorSummaryTest extends TestCase
{
    use TestTrait;

    public function dataProviderErrorSummary(): array
    {
        return [
            [
                'Jack Ryan',
                'jack@example.com',
                'A258*fgh',
                [],
                '<div style="display:none"><p>Please fix the following errors:</p><ul></ul></div>',
            ],
            [
                'Jack Ryan',
                'jack@example.com',
                'A258*fgh',
                ['header' => 'Custom header', 'footer' => 'Custom footer', 'style' => 'color: red'],
                '<div style="color: red; display:none">Custom header<ul></ul>Custom footer</div>',
            ],
            [
                'jac',
                'jack@.com',
                'A258*f',
                ['showAllErrors' => true],
                '<div><p>Please fix the following errors:</p><ul><li>Is too short.</li>' . "\n" .
                '<li>This value is not a valid email address.</li>' . "\n" .
                '<li>Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters.</li></ul></div>',
            ],
        ];
    }

    /**
     * @dataProvider dataProviderErrorSummary
     *
     * @param string $name
     * @param string $email
     * @param string $password
     * @param array $attributes
     * @param string $expected
     */
    public function testErrorSummary(
        string $name,
        string $email,
        string $password,
        array $attributes,
        string $expected
    ): void {
        $record = [
            'PersonalForm' => [
                'name' => $name,
                'email' => $email,
                'password' => $password,
            ],
        ];

        $data = new PersonalForm();
        $data->load($record);

        $validator = $this->createValidatorMock();
        $validator->validate($data);
        $this->assertEqualsWithoutLE(
            $expected,
            ErrorSummary::widget()->attributes($attributes)->model($data)->render(),
        );
    }

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer(), []);
    }

    private function createValidatorMock(): ValidatorInterface
    {
        return new ValidatorMock();
    }
}
