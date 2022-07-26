<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\TestSupport\Form;

use Yiisoft\Form\FormModel;
use Yiisoft\Validator\Rule\Email;
use Yiisoft\Validator\Rule\HasLength;
use Yiisoft\Validator\Rule\Number;
use Yiisoft\Validator\Rule\Required;
use Yiisoft\Validator\Rule\Regex;
use Yiisoft\Validator\Rule\Url;

final class AttributesValidatorForm extends FormModel
{
    private string $checkbox = '';
    private string $email = '';
    private string $number = '';
    private string $password = '';
    private string $pattern = '';
    private string $required = '';
    private string $telephone = '';
    private string $text = '';
    private string $textArea = '';
    private string $url = '';

    public function getRules(): array
    {
        return [
            'checkbox' => [
                new Required(),
            ],
            'email' => [
                new Required(),
                new HasLength(
                    min: 8,
                    max: 20,
                    lessThanMinMessage: 'Is too short.',
                    greaterThanMaxMessage: 'Is too long.'
                ),
                new Regex(
                    '/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/',
                    message: 'Is not a valid email address.'
                ),
                new Email(),
            ],
            'number' => [
                new Required(),
                new Number(min: 3, max: 5, tooSmallMessage: 'Is too small.', tooBigMessage: 'Is too big.'),
            ],
            'pattern' => [
                new Regex('/\w+/'),
            ],
            'password' => [
                new Required(),
                new HasLength(
                    min: 4,
                    max: 8,
                    lessThanMinMessage: 'Is too short.',
                    greaterThanMaxMessage: 'Is too long.'
                ),
                new Regex(
                    '/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{4,8}$/',
                    message: 'Is not a valid password.'
                ),
            ],
            'telephone' => [
                new Required(),
                new HasLength(
                    min: 8,
                    max: 16,
                    lessThanMinMessage: 'Is too short.',
                    greaterThanMaxMessage: 'Is too long.'
                ),
                new Regex('/[^0-9+\(\)-]/', message: 'Is not a valid telephone number.'),
            ],
            'text' => [
                new Required(),
                new HasLength(
                    min: 3,
                    max: 6,
                    lessThanMinMessage: 'Is too short.',
                    greaterThanMaxMessage: 'Is too long.'
                ),
                new Regex('/^[a-zA-Z0-9_.-]+$/', message: 'Is not a valid text.'),
            ],
            'textArea' => [
                new Required(),
                new HasLength(
                    min: 10,
                    max: 100,
                    lessThanMinMessage: 'Is too short.',
                    greaterThanMaxMessage: 'Is too long.'
                ),
                new Regex('/^[a-zA-Z ]*$/', message: 'Is not a valid text.'),
            ],
            'url' => [
                new Required(),
                new HasLength(
                    min: 15,
                    max: 20,
                    lessThanMinMessage: 'Is too short.',
                    greaterThanMaxMessage: 'Is too long.'
                ),
                new Regex(
                    '/^(http|https):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/',
                    message: 'Is not a valid URL.',
                ),
                new Url(),
            ],
        ];
    }

    public function getAttributeHints(): array
    {
        return ['checkbox' => 'Mark the checkbox.', 'email' => 'Write your email.'];
    }
}
