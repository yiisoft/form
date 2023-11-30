<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\TestSupport\Form;

use Yiisoft\Form\YiiValidator\FormModel;
use Yiisoft\Form\Tests\TestSupport\Dto\Coordinates;

final class FormWithNestedStructures extends FormModel
{
    private array $array = [];
    private ?Coordinates $coordinates = null;

    public function getArray(): array
    {
        return $this->array;
    }

    public function getCoordinates(): ?Coordinates
    {
        return $this->coordinates;
    }
}
