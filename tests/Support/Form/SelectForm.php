<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Support\Form;

use stdClass;
use Yiisoft\Form\FormModel;
use Yiisoft\Validator\Rule\Required;

final class SelectForm extends FormModel
{
    private ?int $number = null;
    private int $count = 15;
    private array $letters = ['A', 'C'];
    private ?string $item = null;
    private stdClass $object;
    private ?int $color = null;
    public ?int $requiredWhen = null;

    public function __construct()
    {
        parent::__construct();
        $this->object = new stdClass();
    }

    public function getRules(): array
    {
        return [
            'color' => [new Required()],
            'requiredWhen' => [new Required(when: static fn() => false)],
        ];
    }

    public function getAttributeLabels(): array
    {
        return [
            'number' => 'Select number',
            'count' => 'Select count',
            'letters' => 'Select letters',
        ];
    }
}
