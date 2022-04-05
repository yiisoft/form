<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\TestSupport\Form\Nested;

use Yiisoft\Form\FormModel;

final class PageSearchForm extends FormModel
{
    protected ?array $source_ids = null;
    protected ?array $url_ids = null;

    public function setAttribute(string $name, $value): void
    {
        if ($name === 'source_ids' || $name === 'url_ids') {
            $value = empty($value) ? null : filter_var($value, FILTER_VALIDATE_INT, [
                'options' => [
                    'min_range' => 1
                ],
                'flags' => FILTER_FORCE_ARRAY
            ]);
        }

        parent::setAttribute($name, $value);
    }

    public function getAttributeHints(): array
    {
        $hints = parent::getAttributeHints();
        $hints['source_ids'] = 'IDs of sources';
        $hints['url_ids'] = 'IDs of urls';

        return $hints;
    }

    public function getAttributeLabels(): array
    {
        $labels = parent::getAttributeLabels();
        $labels['source_ids'] = 'Sources';
        $labels['url_ids'] = 'URLs';

        return $labels;
    }

    public function getAttributePlaceholders(): array
    {
        $placeholders = parent::getAttributePlaceholders();
        $placeholders['source_ids'] = 'Start typing source name';

        return $placeholders;
    }
}
