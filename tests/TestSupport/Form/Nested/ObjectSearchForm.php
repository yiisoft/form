<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\TestSupport\Form\Nested;

use Yiisoft\Form\FormModel;

final class ObjectSearchForm extends FormModel
{
    protected ?array $fiases = null;
    protected ?array $type_ids = null;
    protected ?bool $is_active = null;

    public function setAttribute(string $name, $value): void
    {
        if ($name === 'fiases' || $name === 'type_ids') {
            $value = empty($value) ? null : (array) $value;

            parent::setAttribute($name, $value);
        }

        if ($name === 'is_active') {
            $this->is_active  = $value === '' || $value === null ? null : (bool) $value;
        }
    }

    public function getAttributeHints(): array
    {
        $hints = parent::getAttributeHints();
        $hints['type_ids'] = 'IDs of object types';
        $hints['fiases'] = 'List of address FIAS numbers';

        return $hints;
    }
}
