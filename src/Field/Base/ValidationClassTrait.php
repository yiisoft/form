<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field\Base;

use Yiisoft\Form\FormModelInterface;
use Yiisoft\Html\Html;

/**
 * @psalm-require-extends BaseField
 */
trait ValidationClassTrait
{
    private ?string $invalidClass = null;
    private ?string $validClass = null;

    /**
     * Set invalid CSS class.
     */
    public function invalidClass(string $class): static
    {
        $new = clone $this;
        $new->invalidClass = $class;
        return $new;
    }

    /**
     * Set valid CSS class.
     */
    public function validClass(string $class): static
    {
        $new = clone $this;
        $new->validClass = $class;
        return $new;
    }

    protected function addValidationClassToTagAttributes(
        array &$tagAttributes,
        FormModelInterface $formModel,
        string $attributeName,
    ): void {
        if (!$formModel->isValidated()) {
            return;
        }

        $hasErrors = $formModel->getFormErrors()->hasErrors($attributeName);

        if ($hasErrors && $this->invalidClass !== null) {
            Html::addCssClass($tagAttributes, $this->invalidClass);
        }

        if (!$hasErrors && $this->validClass !== null) {
            Html::addCssClass($tagAttributes, $this->validClass);
        }
    }
}
