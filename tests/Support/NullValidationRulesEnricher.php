<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Support;

use Yiisoft\Form\Field\Base\BaseField;
use Yiisoft\Form\ValidationRulesEnricherInterface;

final class NullValidationRulesEnricher implements ValidationRulesEnricherInterface
{
    public function process(BaseField $field, mixed $rules): ?array
    {
        return null;
    }
}
