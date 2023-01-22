<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\TestSupport\Form;

use Yiisoft\Form\FormModel;
use Yiisoft\Validator\Rule\Email;
use Yiisoft\Validator\Rule\Required;

final class AttributeForm extends FormModel
{
    #[Required()]
    private string $username = '';
    #[Required()]
    #[Email()]
    private string $email = '';
}
