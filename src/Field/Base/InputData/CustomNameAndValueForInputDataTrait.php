<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field\Base\InputData;

trait CustomNameAndValueForInputDataTrait
{
    final public function name(?string $name): static
    {
        $new = clone $this;
        $new->inputData = $this->getInputData()->withName($name);
        return $new;
    }

    final public function value(mixed $value): static
    {
        $new = clone $this;
        $new->inputData = $this->getInputData()->withValue($value);
        return $new;
    }
}
