<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\TestSupport\Form\Nested;

use Yiisoft\Form\FormModel;

final class PageDataSearchForm extends FormModel
{
    protected ?array $fiases = null;
    protected ?array $ids = null;

    protected PageSearchForm $page;

    public function __construct()
    {
        parent::__construct();

        $this->page = new PageSearchForm();
    }

    public function setAttribute(string $name, $value): void
    {
        if ($name === 'fiases') {
            $value = empty($value) ? null : (array) $value;
        } elseif ($name === 'ids') {
            $value = empty($value) ? null : filter_var($value, FILTER_VALIDATE_INT, [
                'options' => [
                    'min_range' => 1
                ],
                'flags' => FILTER_FORCE_ARRAY
            ]);
        }

        parent::setAttribute($name, $value);
    }

    public function getAttributeLabels(): array
    {
        $labels = parent::getAttributeLabels();
        $labels['ids'] = 'Data ID';

        return $labels;
    }
}
