<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\TestSupport\Form;

use Yiisoft\Form\FormModel;

final class TypeForm extends FormModel
{
    private ?array $array = [];
    private bool $bool = false;
    private float $float = 0;
    private int $int = 0;
    private ?int $number = null;
    private ?object $object = null;
    private ?string $string = '';
    private string $toCamelCase = '';
    private ?string $toDate = '';
    private ?string $toNull = null;
}
