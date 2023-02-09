<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Support\Form;

use Yiisoft\Form\FormModel;
use Yiisoft\Validator\Rule\Email;
use Yiisoft\Validator\Rule\Length;
use Yiisoft\Validator\Rule\Regex;
use Yiisoft\Validator\Rule\Required;
use Yiisoft\Validator\Rule\StopOnError;

final class ContactForm extends FormModel
{
    #[StopOnError([new Required(), new Email(), new Length(min:5, max:20)])]
    private string $email = '';
    #[Required(), Length(min:5, max:20), Regex(pattern: '/^[a-zA-Z0-9\s]+$/')]
    private string $name = '';
    #[StopOnError([new Required(), new Length(min:5), new Regex(pattern: '/^[a-zA-Z0-9\s]+$/')])]
    private string $subject = '';
}
