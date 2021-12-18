<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field;

use InvalidArgumentException;
use Yiisoft\Form\Field\Base\AbstractField;
use Yiisoft\Form\Field\Base\PlaceholderTrait;
use Yiisoft\Html\Html;

use function is_string;

final class InputText extends AbstractField
{
    use PlaceholderTrait;

    private array $inputTagAttributes = [];

    public function inputTagAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->inputTagAttributes = $attributes;
        return $new;
    }

    protected function generateInput(): string
    {
        $value = $this->getAttributeValue();

        if (!is_string($value) && $value !== null) {
            throw new InvalidArgumentException('Text widget must be a string or null value.');
        }

        $tagAttributes = $this->inputTagAttributes;

        $this->prepareIdInInputTagAttributes($tagAttributes);
        $this->preparePlaceholderInInputTagAttributes($tagAttributes);

        return Html::textInput($this->getInputName(), $value, $tagAttributes)->render();
    }
}
