<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\YiisoftFormModel\Support\Form;

use Yiisoft\Form\YiisoftFormModel\FormModel;
use Yiisoft\Form\Tests\YiisoftFormModel\Support\Dto\Coordinates;

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
