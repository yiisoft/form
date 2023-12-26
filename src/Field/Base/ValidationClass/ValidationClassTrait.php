<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field\Base\ValidationClass;

use Yiisoft\Form\Field\Base\InputData\InputDataInterface;
use Yiisoft\Html\Html;

/**
 * @psalm-require-extends \Yiisoft\Form\Field\Base\PartsField
 */
trait ValidationClassTrait
{
    private ?string $invalidClass = null;
    private ?string $validClass = null;
    private ?string $inputInvalidClass = null;
    private ?string $inputValidClass = null;

    /**
     * Set invalid CSS class.
     */
    public function invalidClass(?string $class): self
    {
        $new = clone $this;
        $new->invalidClass = $class;
        return $new;
    }

    /**
     * Set valid CSS class.
     */
    public function validClass(?string $class): self
    {
        $new = clone $this;
        $new->validClass = $class;
        return $new;
    }

    /**
     * Set invalid CSS class for input tag.
     */
    public function inputInvalidClass(?string $class): self
    {
        $new = clone $this;
        $new->inputInvalidClass = $class;
        return $new;
    }

    /**
     * Set valid CSS class for input tag.
     */
    public function inputValidClass(?string $class): self
    {
        $new = clone $this;
        $new->inputValidClass = $class;
        return $new;
    }

    protected function addValidationClassToAttributes(
        array &$attributes,
        InputDataInterface $inputData,
        ?bool $hasCustomError = null,
    ): void
    {
        $this->addClassesToAttributes(
            $attributes,
            $inputData,
            $hasCustomError,
            $this->invalidClass,
            $this->validClass,
        );
    }

    protected function addInputValidationClassToAttributes(
        array &$attributes,
        InputDataInterface $inputData,
        ?bool $hasCustomError = null,
    ): void
    {
        $this->addClassesToAttributes(
            $attributes,
            $inputData,
            $hasCustomError,
            $this->inputInvalidClass,
            $this->inputValidClass,
        );
    }

    private function addClassesToAttributes(
        array &$attributes,
        InputDataInterface $inputData,
        ?bool $hasCustomError,
        ?string $invalidClass,
        ?string $validClass,
    ): void {
        if (!$inputData->isValidated() && $hasCustomError === null) {
            return;
        }

        $hasErrors = $hasCustomError || !empty($inputData->getValidationErrors());

        if ($hasErrors && $invalidClass !== null) {
            Html::addCssClass($attributes, $invalidClass);
        }

        if (!$hasErrors && $validClass !== null) {
            Html::addCssClass($attributes, $validClass);
        }
    }
}
