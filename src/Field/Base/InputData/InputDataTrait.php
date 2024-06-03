<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field\Base\InputData;

trait InputDataTrait
{
    private ?InputDataInterface $inputData = null;

    final public function inputData(InputDataInterface $inputData): static
    {
        $new = clone $this;
        $new->inputData = $inputData;
        return $new;
    }

    final protected function getInputData(): InputDataInterface
    {
        if ($this->inputData === null) {
            $this->inputData = new InputData();
        }

        return $this->inputData;
    }
}
