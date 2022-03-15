<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\TestSupport\Form;

use Yiisoft\Form\FormModel;
use Yiisoft\Validator\Rule\Nested;
use Yiisoft\Validator\Rule\Required;

final class MainFormNested extends FormModel
{
    protected string $value = '';
    protected NestedForm $nestedForm;

    public function __construct()
    {
        parent::__construct();
        $this->nestedForm = new NestedForm();
    }

    public function getRules(): array
    {
        return [
            'value' => [Required::rule()],
            'nestedForm' => [Nested::rule($this->nestedForm->getRules())],
        ];
    }
}
