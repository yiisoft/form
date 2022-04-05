<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\TestSupport\Form\Nested;

use Yiisoft\Form\FormModel;

final class NumberSearchForm extends FormModel
{
    protected ?array $fiases = null;
    protected mixed $numbers = null;

    public function setAttribute(string $name, $value): void
    {
        if ($name === 'fiases') {
            $value = empty($value) ? null : (array) $value;
        }

        parent::setAttribute($name, $value);
    }

    public function getAttributePlaceholders(): array
    {
        $placeholders = parent::getAttributePlaceholders();
        $placeholders['numbers'] = 'Start typing number';

        return $placeholders;
    }
}
