<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field\Base\InputData;

use Yiisoft\Form\PureField\InputData;

/**
 * @psalm-type PrepareValueCallback = callable(mixed): mixed
 */
trait InputDataWithCustomNameAndValueTrait
{
    private ?InputDataInterface $inputData = null;
    private bool $useCustomName = false;
    private ?string $customName = null;
    private bool $useCustomValue = false;
    private mixed $customValue = null;

    /**
     * @psalm-var PrepareValueCallback|null
     */
    private mixed $prepareValueCallback = null;

    final public function inputData(InputDataInterface $inputData): static
    {
        $new = clone $this;
        $new->inputData = $inputData;
        $new->useCustomName = false;
        $new->useCustomValue = false;
        return $new;
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

    /**
     * @psalm-param PrepareValueCallback|null $callback
     */
    final public function prepareValue(?callable $callback): static
    {
        $new = clone $this;
        $new->prepareValueCallback = $callback;
        return $new;
    }

    final protected function getInputData(): InputDataInterface
    {
        if ($this->inputData === null) {
            $this->inputData = new InputData();
        }

        return $this->inputData;
    }

    final protected function getName(): ?string
    {
        return $this->useCustomName
            ? $this->customName
            : $this->getInputData()->getName();
    }

    final protected function getValue(): mixed
    {
        $value = $this->useCustomValue
            ? $this->customValue
            : $this->getInputData()->getValue();

        return $this->prepareValueCallback === null
            ? $value
            : ($this->prepareValueCallback)($value);
    }
}
