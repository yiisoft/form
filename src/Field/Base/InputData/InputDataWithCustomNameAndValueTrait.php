<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field\Base\InputData;

trait InputDataWithCustomNameAndValueTrait
{
    private ?InputDataInterface $inputData = null;
    private bool $useCustomName = false;
    private ?string $customName = null;
    private bool $useCustomValue = false;
    private mixed $customValue = null;

    final public function inputData(InputDataInterface $inputData): static
    {
        $new = clone $this;
        $new->inputData = $inputData;
        $new->useCustomName = false;
        $new->useCustomValue = false;
        return $new;
    }

    final protected function getInputData(): InputDataInterface
    {
        if ($this->inputData === null) {
            $this->inputData = new PureInputData();
        }

        return $this->inputData;
    }

    final public function name(?string $name): static
    {
        $new = clone $this;
        $new->customName = $name;
        $new->useCustomName = true;
        return $new;
    }

    final public function value(mixed $value): static
    {
        $new = clone $this;
        $new->customValue = $value;
        $new->useCustomValue = true;
        return $new;
    }

    final protected function getName(): ?string
    {
        return $this->useCustomName
            ? $this->customName
            : $this->getInputData()->getName();
    }

    final protected function getValue(): mixed
    {
        return $this->useCustomValue
            ? $this->customValue
            : $this->getInputData()->getValue();
    }
}
