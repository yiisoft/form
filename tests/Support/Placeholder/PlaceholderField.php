<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Support\Placeholder;

final class PlaceholderField extends BasePlaceholder
{
    protected function generateInput(): string
    {
        $attributes = [];
        $this->preparePlaceholderInInputAttributes($attributes);

        return '<b>' . ($attributes['placeholder'] ?? '') . '</b>';
    }
}
