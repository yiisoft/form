<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field;

use InvalidArgumentException;
use Yiisoft\Form\Field\Base\AbstractField;
use Yiisoft\Html\Html;

use function is_string;

final class Hidden extends AbstractField
{
    protected bool $useContainer = false;
    protected string $template = "{input}";

    protected function generateInput(): string
    {
        $value = $this->getAttributeValue();

        if (!is_string($value) && !is_numeric($value) && $value !== null) {
            throw new InvalidArgumentException('Hidden widget requires a string, numeric or null value.');
        }

        $tagAttributes = $this->getInputTagAttributes();

        /** @psalm-suppress MixedArgumentTypeCoercion */
        return Html::hiddenInput($this->getInputName(), $value, $tagAttributes)->render();
    }
}
