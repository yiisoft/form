<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;
use Yiisoft\Form\Tests\TestSupport\Form\PersonalForm;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Widget\ErrorSummary;

final class ErrorSummaryTest extends TestCase
{
    use TestTrait;

    public function dataProviderErrorSummary(): array
    {
        return [
            // Default settings.
            [
                'jack@.com',
                'jac',
                'A258*f',
                [],
                '',
                ['class' => 'text-danger'],
                '',
                [],
                true,
                [],
                <<<HTML
                <div>
                <p class="text-danger">Please fix the following errors:</p>
                <ul>
                <li>This value is not a valid email address.</li>
                <li>Is too short.</li>
                <li>Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters.</li>
                </ul>
                </div>
                HTML,
            ],
            // Set custom header and custom footer.
            [
                'jack@.com',
                'jac',
                'A258*f',
                [],
                'Custom header',
                ['class' => 'text-danger'],
                'Custom footer',
                ['class' => 'text-primary'],
                true,
                [],
                <<<HTML
                <div>
                <p class="text-danger">Custom header</p>
                <ul>
                <li>This value is not a valid email address.</li>
                <li>Is too short.</li>
                <li>Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters.</li>
                </ul>
                <p class="text-primary">Custom footer</p>
                </div>
                HTML,
            ],
            // Set only attributes with showAllErros its `true`.
            [
                'jack@.com',
                'jac',
                'A258*f',
                [],
                '',
                ['class' => 'text-danger'],
                '',
                ['class' => 'text-primary'],
                true,
                ['name'],
                <<<HTML
                <div>
                <p class="text-danger">Please fix the following errors:</p>
                <ul>
                <li>Is too short.</li>
                </ul>
                </div>
                HTML,
            ],
            // Set only attributes with showAllErros `false`.
            [
                'jack@.com',
                'jac',
                'A258*f',
                [],
                '',
                ['class' => 'text-danger'],
                '',
                ['class' => 'text-primary'],
                false,
                ['password'],
                <<<HTML
                <div>
                <p class="text-danger">Please fix the following errors:</p>
                <ul>
                <li>Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters.</li>
                </ul>
                </div>
                HTML,
            ],
        ];
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testImmutability(): void
    {
        $errorSummary = ErrorSummary::widget();
        $this->assertNotSame($errorSummary, $errorSummary->attributes([]));
        $this->assertNotSame($errorSummary, $errorSummary->encode(false));
        $this->assertNotSame($errorSummary, $errorSummary->footer(''));
        $this->assertNotSame($errorSummary, $errorSummary->header(''));
        $this->assertNotSame($errorSummary, $errorSummary->model(new PersonalForm()));
        $this->assertNotSame($errorSummary, $errorSummary->onlyAttributes(''));
        $this->assertNotSame($errorSummary, $errorSummary->showAllErrors(false));
        $this->assertNotSame($errorSummary, $errorSummary->tag('div'));
    }

    /**
     * @dataProvider dataProviderErrorSummary
     *
     * @param string $name
     * @param string $email
     * @param string $password
     * @param array $attributes
     * @param string $header
     * @param array $headerAttributes
     * @param string $footer
     * @param array $footerAttributes
     * @param bool $showAllErrors
     * @param array $onlyAttributes
     * @param string $expected
     *
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testErrorSummary(
        string $email,
        string $name,
        string $password,
        array $attributes,
        string $header,
        array $headerAttributes,
        string $footer,
        array $footerAttributes,
        bool $showAllErrors,
        array $onlyAttributes,
        string $expected
    ): void {
        $formModel = new PersonalForm();

        $record = [
            'PersonalForm' => [
                'email' => $email,
                'name' => $name,
                'password' => $password,
            ],
        ];

        $formModel->load($record);

        $validator = $this->createValidatorMock();
        $validator->validate($formModel);

        $errorSummary = ErrorSummary::widget()
            ->attributes($attributes)
            ->onlyAttributes(...$onlyAttributes)
            ->footer($footer)
            ->footerAttributes($footerAttributes)
            ->headerAttributes($headerAttributes)
            ->model($formModel)
            ->showAllErrors($showAllErrors);

        $errorSummary = $header !== '' ? $errorSummary->header($header) : $errorSummary;

        $this->assertEqualsWithoutLE($expected, $errorSummary->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testTagException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Tag name cannot be empty.');
        ErrorSummary::widget()->tag('')->render();
    }
}
