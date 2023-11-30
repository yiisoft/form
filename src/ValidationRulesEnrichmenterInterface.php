<?php

declare(strict_types=1);

namespace Yiisoft\Form;

use Yiisoft\Form\Field\Base\BaseField;

interface ValidationRulesEnrichmenterInterface
{
    public function process(BaseField $field, mixed $rules): ?array;
}
