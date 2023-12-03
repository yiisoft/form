<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Support\ValidationClassTrait;

use Yiisoft\Form\Field\Base\InputField;
use Yiisoft\Form\Field\Base\ValidationClass\ValidationClassInterface;
use Yiisoft\Form\Field\Base\ValidationClass\ValidationClassTrait;

abstract class BaseValidationClass extends InputField implements ValidationClassInterface
{
    use ValidationClassTrait;
}
