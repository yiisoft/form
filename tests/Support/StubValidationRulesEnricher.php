<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Support;

use Yiisoft\Form\Field\Base\BaseField;
use Yiisoft\Form\ValidationRulesEnricherInterface;

final class StubValidationRulesEnricher implements ValidationRulesEnricherInterface
{
    public function __construct(
        private ?array $result,
    ) {}

    public function process(BaseField $field, mixed $rules): ?array
    {
        return $this->result;
    }
}
